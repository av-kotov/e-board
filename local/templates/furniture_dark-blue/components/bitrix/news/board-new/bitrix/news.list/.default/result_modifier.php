<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$w = (int)($arParams['IMG_WIDTH']  ?? 0) ?: 200;
$h = (int)($arParams['IMG_HEIGHT'] ?? 0) ?: 200;

foreach ($arResult['ITEMS'] as &$arItem) {
    if (!empty($arItem['PREVIEW_PICTURE']['ID'])) {
        $arItem['CARD_IMG'] = CFile::ResizeImageGet(
            $arItem['PREVIEW_PICTURE']['ID'],
            ['width' => $w, 'height' => $h],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );
    }
}
unset($arItem);