<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<div class="swiper similar-swiper">
    <div class="swiper-wrapper">
        <?php foreach ($arResult["ITEMS"] as $item):
            $img = "";
            if (!empty($item["PREVIEW_PICTURE"]["ID"])) {
                $r = CFile::ResizeImageGet($item["PREVIEW_PICTURE"]["ID"], ["width"=>300,"height"=>200], BX_RESIZE_IMAGE_EXACT, true);
                $img = $r["src"];
            }
            $price = $item["DISPLAY_PROPERTIES"]["PRICE"]["DISPLAY_VALUE"] ?? ($item["PROPERTIES"]["PRICE"]["VALUE"] ?? "");
            $city  = $item["DISPLAY_PROPERTIES"]["CITY"]["DISPLAY_VALUE"]  ?? ($item["PROPERTIES"]["CITY"]["VALUE"]  ?? "");
            ?>
            <a class="swiper-slide similar-card" href="?ELEMENT_ID=<?=$item["ID"]?>">
                <?php if ($img): ?><img class="similar-card__img" src="<?=$img?>" alt="<?=htmlspecialcharsbx($item["NAME"])?>"><?php endif ?>
                <div class="similar-card__title"><?=htmlspecialcharsbx($item["NAME"])?></div>
                <?php if ($price): ?><div class="similar-card__price"><?=htmlspecialcharsbx($price)?></div><?php endif ?>
                <?php if ($city): ?><div class="similar-card__city"><?=htmlspecialcharsbx($city)?></div><?php endif ?>
            </a>
        <?php endforeach ?>
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
