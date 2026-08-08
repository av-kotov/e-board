<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Context;

/**
 * avoska:board.filter
 *
 * Собирает фильтр объявлений и кладёт его в $GLOBALS[FILTER_NAME].
 * Вызывать ДО компонента списка (bitrix:news / news.list).
 */
class BoardFilterComponent extends CBitrixComponent
{
    /** @var array нормализованный пользовательский ввод */
    private array $userInput = [];

    /** @var array собранный фильтр для CIBlockElement */
    private array $filter = [];

    /**
     * Нормализация входных параметров.
     * Вызывается Битриксом до executeComponent().
     */
    public function onPrepareComponentParams($arParams): array
    {
        $arParams['IBLOCK_ID']   = (int)($arParams['IBLOCK_ID'] ?? 0);
        $arParams['FILTER_NAME'] = trim((string)($arParams['FILTER_NAME'] ?? '')) ?: 'arBoardFilter';
        $arParams['LIST_URL']    = trim((string)($arParams['LIST_URL'] ?? '')) ?: '/ads/';

        $arParams['CACHE_TIME'] = isset($arParams['CACHE_TIME'])
            ? (int)$arParams['CACHE_TIME']
            : 36000000;

        return $arParams;
    }

    public function executeComponent(): void
    {
        if (!Loader::includeModule('iblock')) {
            ShowError('Модуль "Информационные блоки" не установлен');
            return;
        }

        if ($this->arParams['IBLOCK_ID'] <= 0) {
            ShowError('Не указан ID инфоблока');
            return;
        }

        $this->readRequest();
        $this->buildFilter();

        // ВАЖНО: фильтр уходит в глобальную область ДО кеша.
        // На кеш-хите тело startResultCache() не выполнится,
        // а фильтр всё равно должен быть собран — его ждёт список.
        $GLOBALS[$this->arParams['FILTER_NAME']] = $this->filter;

        if ($this->startResultCache(false, [$this->userInput, $this->arParams['IBLOCK_ID']])) {

            $this->arResult = [
                'CATEGORIES'  => $this->getCategories(),
                'CITIES'      => $this->getCities(),
                'REQUEST'     => $this->userInput,
                'LIST_URL'    => $this->arParams['LIST_URL'],
                'IS_FILTERED' => !empty($this->filter),
            ];

            $this->includeComponentTemplate();
        }
    }

    /**
     * Читаем пользовательский ввод из запроса.
     */
    private function readRequest(): void
    {
        $r = Context::getCurrent()->getRequest();

        $this->userInput = [
            'q'          => trim((string)$r->get('q')),
            'category'   => (int)$r->get('category'),
            'city'       => trim((string)$r->get('city')),
            'price_from' => trim((string)$r->get('price_from')),
            'price_to'   => trim((string)$r->get('price_to')),
        ];
    }

    /**
     * Собираем массив фильтра для CIBlockElement::GetList.
     */
    private function buildFilter(): void
    {
        $filter = [];

        if ($this->userInput['q'] !== '') {
            $filter['?NAME'] = $this->userInput['q'];
        }

        if ($this->userInput['category'] > 0) {
            // фильтруем по enum-ID, а не по тексту значения
            $filter['PROPERTY_CATEGORY'] = $this->userInput['category'];
        }

        if ($this->userInput['city'] !== '') {
            $filter['=PROPERTY_CITY'] = $this->userInput['city'];
        }

        // Цена: работаем с ЧИСЛОВЫМ свойством PRICE_NUM.
        // Строковый PRICE («120 000 руб») в диапазоне сравнивался бы
        // лексикографически: «90 000» оказалось бы больше «120 000».
        $from = preg_replace('/\D/', '', $this->userInput['price_from']);
        $to   = preg_replace('/\D/', '', $this->userInput['price_to']);

        if ($from !== '') {
            $filter['>=PROPERTY_PRICE'] = (int)$from;
        }
        if ($to !== '') {
            $filter['<=PROPERTY_PRICE'] = (int)$to;
        }

        $this->filter = $filter;
    }

    /**
     * Значения списочного свойства CATEGORY.
     * Свойство ищем по КОДУ — ID меняется при пересоздании.
     */
    private function getCategories(): array
    {
        $result = [];

        $prop = CIBlockProperty::GetList(
            [],
            ['IBLOCK_ID' => $this->arParams['IBLOCK_ID'], 'CODE' => 'CATEGORY']
        )->Fetch();

        if (!$prop) {
            return $result;
        }

        $enum = CIBlockPropertyEnum::GetList(
            ['SORT' => 'ASC', 'VALUE' => 'ASC'],
            [
                'IBLOCK_ID'   => $this->arParams['IBLOCK_ID'],
                'PROPERTY_ID' => $prop['ID'],
            ]
        );

        while ($item = $enum->GetNext()) {
            $result[] = [
                'ID'    => $item['ID'],
                'VALUE' => $item['VALUE'],
            ];
        }

        return $result;
    }

    /**
     * Уникальные города — собираем из самих элементов.
     */
    private function getCities(): array
    {
        $res = CIBlockElement::GetList(
            ['PROPERTY_CITY' => 'ASC'],
            ['IBLOCK_ID' => $this->arParams['IBLOCK_ID'], 'ACTIVE' => 'Y'],
            false,
            false,
            ['ID', 'PROPERTY_CITY']
        );

        $cities = [];
        while ($el = $res->Fetch()) {
            $city = trim((string)$el['PROPERTY_CITY_VALUE']);
            if ($city !== '') {
                $cities[$city] = true;
            }
        }

        $cities = array_keys($cities);
        sort($cities);

        return $cities;
    }
}