<?php

namespace Board;

use Bitrix\Main\Loader;

class Iblock
{
    private static array $cache = [];

    /**
     * Возвращает ID инфоблока по символьному коду.
     * Результат кешируется в памяти запроса.
     */
    public static function getIdByCode(string $code, string $type = ''): int
    {
        $cacheKey = $type . ':' . $code;

        if (isset(self::$cache[$cacheKey])) {
            return self::$cache[$cacheKey];
        }

        Loader::includeModule('iblock');

        $filter = ['CODE' => $code, 'CHECK_PERMISSIONS' => 'N'];
        if ($type !== '') {
            $filter['TYPE'] = $type;
        }

        $iblock = \CIBlock::GetList([], $filter)->Fetch();
        $id = $iblock ? (int)$iblock['ID'] : 0;

        self::$cache[$cacheKey] = $id;
        return $id;
    }
}
