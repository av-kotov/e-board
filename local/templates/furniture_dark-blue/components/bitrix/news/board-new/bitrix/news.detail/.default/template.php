<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="news-detail">

    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
        <img class="detail_picture"
             src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
             width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
             height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
             alt="<?=$arResult["NAME"]?>"
             title="<?=$arResult["NAME"]?>" />
    <?endif?>

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
                            <?if(is_array($arProperty["DISPLAY_VALUE"])):?>
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
