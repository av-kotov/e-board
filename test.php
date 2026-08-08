<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

global $USER;
if (!$USER->IsAdmin()) {
    die('Только для администратора');
}

\Bitrix\Main\Loader::includeModule('iblock');

const IBLOCK_ID = 8;
const PROP_CODE = 'PRICE';

$dryRun = ($_GET['apply'] ?? '') !== 'yes';

echo '<pre style="font:14px/1.5 monospace">';
echo "=== Очистка свойства " . PROP_CODE . " ===\n";
echo $dryRun
    ? "РЕЖИМ: предпросмотр (ничего не меняется).\nДля записи откройте: ?apply=yes\n\n"
    : "РЕЖИМ: ЗАПИСЬ\n\n";

$res = CIBlockElement::GetList(
    ['ID' => 'ASC'],
    ['IBLOCK_ID' => IBLOCK_ID],
    false,
    false,
    ['ID', 'NAME', 'PROPERTY_' . PROP_CODE]
);

$total = $changed = $clean = $empty = 0;

while ($el = $res->Fetch()) {
    $total++;

    $raw = (string)$el['PROPERTY_' . PROP_CODE . '_VALUE'];
    $num = preg_replace('/\D/', '', $raw);

    if ($num === '') {
        echo sprintf("  [%3d] %-35s  ПУСТО ('%s')\n", $el['ID'], mb_substr($el['NAME'], 0, 35), $raw);
        $empty++;
        continue;
    }

    if ($raw === $num) {
        $clean++;
        continue; // уже чистое, не трогаем
    }

    echo sprintf("  [%3d] %-35s  '%s'  ->  %d\n",
        $el['ID'], mb_substr($el['NAME'], 0, 35), $raw, (int)$num);

    if (!$dryRun) {
        CIBlockElement::SetPropertyValuesEx($el['ID'], IBLOCK_ID, [PROP_CODE => (int)$num]);
    }
    $changed++;
}

echo "\n--- Итого ---\n";
echo "  Всего элементов:     {$total}\n";
echo "  Уже чистых:          {$clean}\n";
echo "  " . ($dryRun ? "Будет изменено:      " : "Изменено:            ") . "{$changed}\n";
echo "  Пустая цена:         {$empty}\n";

if ($dryRun && $changed > 0) {
    echo "\nПроверьте список выше. Если всё верно — откройте ?apply=yes\n";
}

echo '</pre>';
