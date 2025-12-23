<?php

/**
 * App Helpers
 * 
 * Location: app/Helpers/helpers.php
 * 
 * Add this file to composer.json autoload section:
 * "autoload": {
 *     "files": [
 *         "app/Helpers/helpers.php"
 *     ]
 * }
 * 
 * Then run: composer dump-autoload
 */

if (!function_exists('toBengaliNumber')) {
    /**
     * Convert English numbers to Bengali numerals
     *
     * @param int|string $number
     * @return string
     */
    function toBengaliNumber($number): string
    {
        $bengaliNumerals = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        
        return preg_replace_callback('/[0-9]/', function ($matches) use ($bengaliNumerals) {
            return $bengaliNumerals[(int) $matches[0]];
        }, (string) $number);
    }
}

if (!function_exists('toEnglishNumber')) {
    /**
     * Convert Bengali numerals to English numbers
     *
     * @param string $number
     * @return string
     */
    function toEnglishNumber(string $number): string
    {
        $bengaliNumerals = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $englishNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
        return str_replace($bengaliNumerals, $englishNumerals, $number);
    }
}

if (!function_exists('formatBengaliNumber')) {
    /**
     * Format number with Bengali numerals and locale formatting
     *
     * @param int|float $number
     * @param int $decimals
     * @return string
     */
    function formatBengaliNumber($number, int $decimals = 0): string
    {
        $formatted = number_format($number, $decimals);
        return toBengaliNumber($formatted);
    }
}

if (!function_exists('getBengaliMonth')) {
    /**
     * Get Bengali month name
     *
     * @param int $month (1-12)
     * @return string
     */
    function getBengaliMonth(int $month): string
    {
        $months = [
            1 => 'জানুয়ারি',
            2 => 'ফেব্রুয়ারি',
            3 => 'মার্চ',
            4 => 'এপ্রিল',
            5 => 'মে',
            6 => 'জুন',
            7 => 'জুলাই',
            8 => 'আগস্ট',
            9 => 'সেপ্টেম্বর',
            10 => 'অক্টোবর',
            11 => 'নভেম্বর',
            12 => 'ডিসেম্বর',
        ];
        
        return $months[$month] ?? '';
    }
}

if (!function_exists('getBengaliDay')) {
    /**
     * Get Bengali day name
     *
     * @param int $day (0-6, 0 = Sunday)
     * @return string
     */
    function getBengaliDay(int $day): string
    {
        $days = [
            0 => 'রবিবার',
            1 => 'সোমবার',
            2 => 'মঙ্গলবার',
            3 => 'বুধবার',
            4 => 'বৃহস্পতিবার',
            5 => 'শুক্রবার',
            6 => 'শনিবার',
        ];
        
        return $days[$day] ?? '';
    }
}

if (!function_exists('formatBengaliDate')) {
    /**
     * Format date in Bengali
     *
     * @param \Carbon\Carbon|string $date
     * @param string $format Options: 'full', 'short', 'date_only'
     * @return string
     */
    function formatBengaliDate($date, string $format = 'full'): string
    {
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }
        
        $day = toBengaliNumber($date->day);
        $month = getBengaliMonth($date->month);
        $year = toBengaliNumber($date->year);
        $dayName = getBengaliDay($date->dayOfWeek);
        
        return match ($format) {
            'full' => "{$dayName}, {$day} {$month} {$year}",
            'short' => "{$day} {$month} {$year}",
            'date_only' => "{$day}/{$month}/{$year}",
            default => "{$day} {$month} {$year}",
        };
    }
}