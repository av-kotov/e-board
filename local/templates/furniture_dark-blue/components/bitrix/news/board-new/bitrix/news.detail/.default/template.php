<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//\bitrix\Main\Page\Asset::getInstance()->addCss("https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css");
//\bitrix\Main\Page\Asset::getInstance()->addJs("https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js");

//$this->addExternalCss("https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css");
//$this->addExternalJs("https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js");
?>
<div class="news-detail">
    <?php if (!empty($arResult["GALLERY"])): ?>
        <?php if (count($arResult["GALLERY"]) > 1): ?>
            <div class="swiper detail-gallery">
                <div class="swiper-wrapper">
                    <?php foreach ($arResult["GALLERY"] as $src): ?>
                        <div class="swiper-slide"><img src="<?=$src?>" alt="<?=$arResult["NAME"]?>"></div>
                    <?php endforeach ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        <?php else: ?>
            <img class="detail_picture" src="<?=$arResult["GALLERY"][0]?>" alt="<?=$arResult["NAME"]?>">
        <?php endif ?>
    <?php endif ?>
    <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
        <div class="news-date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
    <?endif;?>

    <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
        <h3><?=$arResult["NAME"]?></h3>
    <?endif;?>

    <div class="news-detail">
        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
            <p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
        <?endif;?>

        <?if($arResult["NAV_RESULT"]):?>
            <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
            <?echo $arResult["NAV_TEXT"];?>
            <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
        <?elseif($arResult["DETAIL_TEXT"] <> ''):?>
            <?echo $arResult["DETAIL_TEXT"];?>
        <?else:?>
            <?echo $arResult["PREVIEW_TEXT"];?>
        <?endif?>

        <div style="clear:both"></div>

        <?if(!empty($arResult["FIELDS"]) || !empty($arResult["DISPLAY_PROPERTIES"])):?>
            <div class="ad-meta">
                <?foreach($arResult["FIELDS"] as $code => $value):?>
                    <div class="ad-meta__item">
                        <span class="ad-meta__name"><?=GetMessage("IBLOCK_FIELD_".$code)?></span>
                        <span class="ad-meta__value"><?=$value?></span>
                    </div>
                <?endforeach;?>

                <?foreach($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty):?>
                    <div class="ad-meta__item">
                        <span class="ad-meta__name"><?=$arProperty["NAME"]?></span>
                        <span class="ad-meta__value">
            <?if($pid == "PRICE"):?>
                <?if($arProperty["VALUE"] > 0):?>
                    <?=number_format($arProperty["VALUE"], 0, '', ' ')?> ₽
                <?else:?>
                    Цена договорная
                <?endif?>
            <?elseif(is_array($arProperty["DISPLAY_VALUE"])):?>
                <?=implode(" / ", $arProperty["DISPLAY_VALUE"])?>
            <?else:?>
                <?=$arProperty["DISPLAY_VALUE"]?>
            <?endif?>
        </span>
                    </div>
                <?endforeach;?>
            </div>
        <?endif;?>
    </div>
</div>


<?php if (!empty($GLOBALS["similarFilter"])): ?>
    <section class="similar-ads">
        <h3 class="similar-ads__title">Похожие объявления</h3>
        <?php $APPLICATION->IncludeComponent("bitrix:news.list", "similar", [
                "IBLOCK_TYPE"   => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID"     => $arParams["IBLOCK_ID"],
                "NEWS_COUNT"    => 8,
                "FILTER_NAME"   => "similarFilter",
                "SORT_BY1"      => "ID",
                "SORT_ORDER1"   => "DESC",
                "PROPERTY_CODE" => ["PRICE", "CITY"],
                "CACHE_TYPE"    => "N",
                "SET_TITLE"     => "N",
                "SET_STATUS_404"=> "N",
                "DISPLAY_DATE"  => "N",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "AJAX_MODE"     => "N",
        ], $component, ["HIDE_ICONS" => "Y"]); ?>
    </section>
<?php endif; ?>

<?php if (!empty($GLOBALS["sellerFilter"])): ?>
    <section class="similar-ads">
        <h3 class="similar-ads__title">Другие объявления продавца</h3>
        <?php $APPLICATION->IncludeComponent("bitrix:news.list", "similar", [
                "IBLOCK_TYPE"   => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID"     => $arParams["IBLOCK_ID"],
                "NEWS_COUNT"    => 8,
                "FILTER_NAME"   => "sellerFilter",
                "SORT_BY1"      => "ID",
                "SORT_ORDER1"   => "DESC",
                "PROPERTY_CODE" => ["PRICE", "CITY"],
                "CACHE_TYPE"    => "N",
                "SET_TITLE"     => "N",
                "SET_STATUS_404"=> "N",
                "DISPLAY_DATE"  => "N",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "AJAX_MODE"     => "N",
        ], $component, ["HIDE_ICONS" => "Y"]); ?>
    </section>
<?php endif; ?>
