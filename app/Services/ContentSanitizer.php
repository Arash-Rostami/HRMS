<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
class ContentSanitizer
{
    private const MAX_BYTES = 65000;

    public static function clean(?string $html): ?string
    {
        if ($html === null || $html === '') return $html;

        $html = self::toUtf8($html);
        $html = self::stripInvalidControls($html);

        if (!self::dbIsUtf8mb4()) {
            $html = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $html);
        }

        return self::truncateUtf8Bytes($html, self::MAX_BYTES);
    }

    private static function dbIsUtf8mb4(): bool
    {
        try {
            $row = DB::selectOne('SHOW VARIABLES LIKE "character_set_connection"');
            $charset = $row?->Value ?? $row?->value ?? null;
            if (!$charset) return false;

            return stripos($charset, 'utf8mb4') === 0;
        } catch (\Throwable) {
            return false;
        }
    }

    private static function stripInvalidControls(string $v): string
    {
        return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $v);
    }

    private static function toUtf8(string $v): string
    {
        if (!mb_detect_encoding($v, 'UTF-8', true)) {
            $v = mb_convert_encoding($v, 'UTF-8');
        }
        $v = iconv('UTF-8', 'UTF-8//IGNORE', $v);
        return $v === false ? '' : $v;
    }

    private static function truncateUtf8Bytes(string $v, int $limit): string
    {
        if (strlen($v) <= $limit) return $v;

        $bin = substr($v, 0, $limit);
        $len = strlen($bin);
        while ($len > 0 && (ord($bin[$len - 1]) & 0xC0) === 0x80) {
            $len--;
        }
        $bin = substr($bin, 0, $len);

        $bin = iconv('UTF-8', 'UTF-8//IGNORE', $bin);
        return $bin === false ? '' : $bin;
    }
}
