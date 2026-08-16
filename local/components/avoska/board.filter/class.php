<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Main\Context;

class BoardFilterComponent extends CBitrixComponent
{
    private array  $userInput= [];
    private array $filter = [];

    public function onPrepareComponentParams($arParams): array
    {
        $arParams['IBLOCK_ID']   = (int)($arParams['IBLOCK_ID'] ?? 0);
        $arParams['FILTER_NAME'] = trim((string)($arParams['FILTER_NAME'] ?? '')) ?: 'arBoardFilter';
        $arParams['LIST_URL']    = trim((string)($arParams['LIST_URL'] ?? '')) ?: '/ads/';
        $arParams['CACHE_TIME']  = isset($arParams['CACHE_TIME']) ? (int)$arParams['CACHE_TIME'] : 36000000;
        return $arParams;
    }

    public function executeComponent(): void
    {
        if (!Loader::includeModule('iblock')) {
            ShowError(GetMessage('IBLOCK_MODULE_NOT_INSTALLED'));
            return;
        }
        if ($this->arParams["IBLOCK_ID"] <= 0) {
            ShowError('Не указан ID инфоблока');
            return;
        }


        $this->readRequest();
        $this->buildFilter();

        $GLOBALS[$this->arParams['FILTER_NAME']] = $this->filter;

        if ($this->startResultCache(false, [$this->userInput, $this->arParams["IBLOCK_ID"]])) {
            $this->arResult = [
                'CATEGORIES' => $this->getCategories(),
                'CITIES' => $this->getCities(),
                'REQUEST' => $this->userInput,
                'LIST_URL' => $this->arParams['LIST_URL'],
                'IS_FILTERED' => !empty($this->filter),
            ];

            $this->includeComponentTemplate();
        }
    }

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

    private function buildFilter(): void
    {
        $filter = [];

        if ($this->userInput['q'] !== '') {
            $filter['?NAME'] = $this->userInput['q'];
        }

        if ($this->userInput['category'] > 0) {
            $filter['PROPERTY_CATEGORY'] = $this->userInput['category'];
        }

        if ($this->userInput['city'] !== '') {
            $filter['=PROPERTY_CITY'] = $this->userInput['city'];
        }

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

    private function getCategories(): array
    {
        $result = [];

        $prop = CIBlockProperty::GetList([], ['IBLOCK_ID' => $this->arParams['IBLOCK_ID'], 'CODE' => 'CATEGORY'])->Fetch();
        if (!$prop) {
            return $result;
        }

        $enum = CIBlockPropertyEnum::GetList(
            ['SORT' => 'ASC', 'VALUE' => 'ASC'],
            ['IBLOCK_ID' => $this->arParams['IBLOCK_ID'], 'PROPERTY_ID' => $prop['ID']]
        );

        while ($item = $enum->GetNext()) {
            $result[] = ['ID' => $item['ID'], 'VALUE' => $item['VALUE']];
        }

        return $result;
    }

    private function getCities(): array
    {
        $res = CIBlockElement::GetList(
            ['PROPERTY_CITY' => 'ASC'],
            ['IBLOCK_ID' => $this->arParams['IBLOCK_ID'], 'ACTIVE' => 'Y'],
            false, false,
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