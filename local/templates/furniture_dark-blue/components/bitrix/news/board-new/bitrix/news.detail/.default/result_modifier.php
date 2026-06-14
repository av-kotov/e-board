<?php
$width = 700; $height = 500;
if (!empty($arResult["DETAIL_PICTURE"]["ID"])) {
    $resized = CFile::ResizeImageGet(
        $arResult["DETAIL_PICTURE"]["ID"],
        ["width" => $width, "height" => $height],
        BX_RESIZE_IMAGE_PROPORTIONAL, true
    );
    if (!empty($resized["src"])) {
        $arResult["DETAIL_PICTURE"]["SRC"]    = $resized["src"];
        $arResult["DETAIL_PICTURE"]["WIDTH"]  = $resized["width"];
        $arResult["DETAIL_PICTURE"]["HEIGHT"] = $resized["height"];
    }
}

$galleryIds = [];
if (!empty($arResult["DETAIL_PICTURE"]["ID"])) $galleryIds[] = $arResult["DETAIL_PICTURE"]["ID"];
$photos = $arResult["PROPERTIES"]["PHOTOS"]["VALUE"] ?? [];
foreach ($photos as $fid) if ($fid) $galleryIds[] = $fid;

$arResult["GALLERY"] = [];
foreach ($galleryIds as $fid) {
    $r = CFile::ResizeImageGet($fid, ["width" => 700, "height" => 500], BX_RESIZE_IMAGE_PROPORTIONAL, true);
    if (!empty($r["src"])) $arResult["GALLERY"][] = $r["src"];
}


$catEnumId = $arResult["PROPERTIES"]["CATEGORY"]["VALUE_ENUM_ID"] ?? null;
if (!empty($catEnumId)) {
    $GLOBALS["similarFilter"] = [
        "PROPERTY_CATEGORY" => $catEnumId,
        "!ID" => $arResult["ID"]
    ];
}

$authorId = $arResult["CREATED_BY"] ?? null;
if (!$authorId && !empty($arResult["ID"])) {
    $row = CIBlockElement::GetList([], ["ID" => $arResult["ID"]], false, false, ["ID", "CREATED_BY"])->Fetch();
    $authorId = $row["CREATED_BY"] ?? null;
}
if ($authorId) {
    $GLOBALS["sellerFilter"] = [
        "CREATED_BY" => $authorId,
        "!ID"        => $arResult["ID"],
    ];
}