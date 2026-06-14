<?php

use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(null, [
    'Board\\Iblock' => '/local/lib/Iblock.php',
]);

function pr($arg){
    echo '<pre>';
    print_r($arg);
    echo '</pre>';
}

function vd($arg) {
    echo '<pre>';
    var_dump($arg);
    echo '</pre>';
}