<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="news-list">
    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?><br />
    <?endif;?>

    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction(
                $arItem['ID'],
                $arItem['EDIT_LINK'],
                CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT")
        );

        $this->AddDeleteAction(
                $arItem['ID'],
                $arItem['DELETE_LINK'],
                CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"),
                array("CONFIRM" => GetMessage('NEWS_DELETE_CONFIRM'))
        );
        ?>

        <div class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

            <?if(!empty($arItem['CARD_IMG'])):?>
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                    <img
                            class="preview_picture"
                            src="<?=$arItem['CARD_IMG']['src']?>"
                            width="<?=$arItem['CARD_IMG']['width']?>"
                            height="<?=$arItem['CARD_IMG']['height']?>"
                            alt="<?=htmlspecialcharsbx($arItem["NAME"])?>"
                            title="<?=htmlspecialcharsbx($arItem["NAME"])?>"
                            style="float:left"
                    />
                </a>
            <?endif;?>

            <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                <div class="news-date">
                    <?=$arItem["DISPLAY_ACTIVE_FROM"]?>
                </div>
            <?endif;?>

            <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                <div class="news-title">
                    <?=$arItem["NAME"]?>
                </div>
            <?endif;?>

            <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                <div class="news-detail">
                    <?=$arItem["PREVIEW_TEXT"]?>
                </div>
            <?endif;?>

            <?if(!empty($arItem['CARD_IMG'])):?>
                <div style="clear:both"></div>
            <?endif;?>

            <?foreach($arItem["FIELDS"] as $code => $value):?>
                <small>
                    <?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
                </small><br />
            <?endforeach;?>

            <?foreach($arItem["DISPLAY_PROPERTIES"] as $pid => $arProperty):?>
                <small>
                    <?=$arProperty["NAME"]?>:&nbsp;

                    <?if(is_array($arProperty["DISPLAY_VALUE"])):?>
                        <?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
                    <?else:?>
                        <?=$arProperty["DISPLAY_VALUE"];?>
                    <?endif;?>
                </small><br />
            <?endforeach;?>

            <a class="news-detail-link" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                <?=GetMessage('MEWS_DETAIL_LINK')?> &rarr;
            </a>

        </div>

    <?endforeach;?>

    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <br /><?=$arResult["NAV_STRING"]?>
    <?endif;?>
</div>