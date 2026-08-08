<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?$APPLICATION->ShowHead();?>
<link href="<?=SITE_TEMPLATE_PATH?>/common.css" type="text/css" rel="stylesheet" />
<link href="<?=SITE_TEMPLATE_PATH?>/colors.css" type="text/css" rel="stylesheet" />



	<!--[if lte IE 6]>
	<style type="text/css">

		#banner-overlay {
			background-image: none;
			filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=SITE_TEMPLATE_PATH?>images/overlay.png', sizingMethod = 'crop');
		}

		div.product-overlay {
			background-image: none;
			filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=SITE_TEMPLATE_PATH?>images/product-overlay.png', sizingMethod = 'crop');
		}

	</style>
	<![endif]-->

	<title><?$APPLICATION->ShowTitle()?></title>
</head>
<body>
	<div id="page-wrapper">
	<div id="panel"><?$APPLICATION->ShowPanel();?></div>
		<div id="header">

			<table id="logo">
				<tr>
					<td><a href="<?=SITE_DIR?>" title="<?=GetMessage('CFT_MAIN')?>"><?
$APPLICATION->IncludeFile(
	SITE_DIR."include/company_name.php",
	Array(),
	Array("MODE"=>"html")
);
?></a></td>
				</tr>
			</table>

			<div id="top-menu">
				<div id="top-menu-inner">
                    <?$APPLICATION->IncludeComponent("bitrix:menu", "horizontal_multilevel", array(
                        "ROOT_MENU_TYPE" => "top",
                        "MAX_LEVEL" => "2",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => ""
                        ),
                        false,
                        array(
                        "ACTIVE_COMPONENT" => "Y"
                        )
                    );?>
				</div>
			</div>

<!--			<div id="top-icons">-->
<!--				<a href="--><?php //=SITE_DIR?><!--" class="home-icon" title="--><?php //=GetMessage('CFT_MAIN')?><!--"></a>-->
<!--				<a href="--><?php //=SITE_DIR?><!--search/" class="search-icon" title="--><?php //=GetMessage('CFT_SEARCH')?><!--"></a>-->
<!--				<a href="--><?php //=SITE_DIR?><!--contacts/" class="feedback-icon" title="--><?php //=GetMessage('CFT_FEEDBACK')?><!--"></a>-->
<!--			</div>-->

		</div>
        <?
        $isBoard  = $APPLICATION->GetCurPage(false) === SITE_DIR.'ads/';
        $isDetail = $_REQUEST['ELEMENT_ID'] ?? 0;
        $isList   = $isBoard && !$isDetail;
        ?>

        <?if ($isList):?>
            <div id="banner-search">
                <?$APPLICATION->IncludeComponent(
        "bitrix:search.title",
        "board-search",
                    [
                        "NUM_CATEGORIES" => "1",
                        "TOP_COUNT" => "5",
                        "CHECK_DATES" => "N",
                        "SHOW_OTHERS" => "N",
                        "PAGE" => SITE_DIR."search/",
                        "CATEGORY_0_TITLE" => "Объявления",
                        "CATEGORY_0" => [
                            0 => "iblock_board",
                        ],
                        "CATEGORY_0_iblock_board" => [
                            0 => "8",
                        ],
                        "SHOW_INPUT" => "Y",
                        "INPUT_ID" => "board-search-input",
                        "CONTAINER_ID" => "board-search",
                        "PRICE_CODE" => "",
                        "SHOW_PREVIEW" => "Y",
                        "PREVIEW_TRUNCATE_LEN" => "80",
                        "CONVERT_CURRENCY" => "N",
                        "COMPONENT_TEMPLATE" => "board-search",
                        "ORDER" => "date",
                        "USE_LANGUAGE_GUESS" => "Y"
                    ],
        false
                );?>
            </div>
        <?else:?>
            <div id="banner">
                <table id="banner-layout">
                    <tr>
                        <td id="banner-image"><div><img src="<?=SITE_TEMPLATE_PATH?>/images/head.jpg" alt=""/></div></td>
                        <td id="banner-slogan">
                            <?$APPLICATION->IncludeFile(
                                    SITE_DIR."include/motto.php",
                                    Array(),
                                    Array("MODE"=>"html")
                            );?>
                        </td>
                    </tr>
                </table>
                <div id="banner-overlay"></div>
            </div>
        <?endif;?>


		<div id="content">



			<div id="sidebar">
                <?if ($isBoard && $isDetail <= 0):?>
                    <?$APPLICATION->IncludeComponent("avoska:board.filter", ".default", [
                            "IBLOCK_TYPE"  => "board",
                            "IBLOCK_ID"    => 8,
                            "FILTER_NAME"  => "arBoardFilter",
                            "LIST_URL"     => SITE_DIR."ads/",
                            "CACHE_TYPE"   => "A",
                            "CACHE_TIME"   => 36000000,
                    ]);?>
                <?else:?>
                    <div class="content-block">
                        <div class="content-block-inner">
                            <h3><?=GetMessage('CFT_NEWS')?></h3>
                                <?
                                    $APPLICATION->IncludeFile(
                                        SITE_DIR."include/news.php",
                                        Array(),
                                        Array("MODE"=>"html")
                                    );
                                    ?>
                        </div>
                    </div>
                <?endif;?>

			</div>
			<div id="workarea">
				<h1 id="pagetitle"><?$APPLICATION->ShowTitle(false);?></h1>