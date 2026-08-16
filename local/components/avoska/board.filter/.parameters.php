<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
Loader::includeModule('iblock');

$arTypes = [];
$rsTypes = CIBlockType::GetList([], ['ACTIVE' => 'Y']);
while ($type = $rsTypes->Fetch()) {
    if ($lang = CIBlockType::GetByIDLang($type['ID'], LANGUAGE_ID)) {
        $arTypes[$type['ID']] = '[' . $type['ID'] . '] ' . $lang['NAME'];
    }
}

$arIBlocks = [];
$rsIBlocks = CIBlock::GetList(['SORT' => 'ASC'], ['TYPE' => $arCurrentValues['IBLOCK_TYPE'] ?? '', 'ACTIVE' => 'Y']);
while ($iblock = $rsIBlocks->Fetch()) {
    $arIBlocks[$iblock['ID']] = '[' . $iblock['ID'] . '] ' . $iblock['NAME'];
}

$arComponentParameters = [
    'GROUPS' => [
        'FILTER' => ['NAME' => 'Настройки фильтра'],
    ],
    'PARAMETERS' => [
        'IBLOCK_TYPE' => [
            'PARENT' => 'BASE', 'NAME' => 'Тип инфоблока', 'TYPE' => 'LIST',
            'VALUES' => $arTypes, 'DEFAULT' => 'board', 'REFRESH' => 'Y',
        ],
        'IBLOCK_ID' => [
            'PARENT' => 'BASE', 'NAME' => 'Инфоблок', 'TYPE' => 'LIST',
            'VALUES' => $arIBlocks, 'DEFAULT' => '', 'REFRESH' => 'Y',
        ],
        'FILTER_NAME' => [
            'PARENT' => 'FILTER', 'NAME' => 'Имя глобальной переменной фильтра',
            'TYPE' => 'STRING', 'DEFAULT' => 'arBoardFilter',
        ],
        'LIST_URL' => [
            'PARENT' => 'FILTER', 'NAME' => 'URL страницы списка (action формы)',
            'TYPE' => 'STRING', 'DEFAULT' => '/ads/',
        ],
        'CACHE_TIME' => ['DEFAULT' => 36000000],
    ],
];
