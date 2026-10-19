<?php

namespace App\Support;

use Carbon\Carbon;

class Bulan
{
    public const NAMES = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    /** Carbon -> "Oktober 2026" */
    public static function label(Carbon $date): string
    {
        return self::NAMES[$date->month].' '.$date->year;
    }

    /** "Oktober 2026" -> Carbon awal bulan, atau null bila format tidak dikenali. */
    public static function parse(string $period): ?Carbon
    {
        if (! preg_match('/^\s*([A-Za-z]+)\s+(\d{4})\s*$/', $period, $m)) {
            return null;
        }

        $lower = array_map('mb_strtolower', self::NAMES);
        $month = array_search(mb_strtolower($m[1]), $lower, true);

        if ($month === false) {
            return null;
        }

        return Carbon::create((int) $m[2], (int) $month, 1)->startOfMonth();
    }

    /** Menyeragamkan penulisan periode agar cocok dengan label(). */
    public static function normalize(string $period): string
    {
        $date = self::parse($period);

        return $date ? self::label($date) : trim($period);
    }
}
