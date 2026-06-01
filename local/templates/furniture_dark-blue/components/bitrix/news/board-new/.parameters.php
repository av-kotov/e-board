<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters = array(
    "IMG_HEIGHT" => Array(
        "NAME"    => GetMessage("BOARD_IMG_HEIGHT"),
        "TYPE"    => "STRING",
        "DEFAULT" => "200",
    ),
    "IMG_WIDTH" => Array(
        "NAME"    => GetMessage("BOARD_IMG_WIDTH"),
        "TYPE"    => "STRING",
        "DEFAULT" => "200",
    ),
);

