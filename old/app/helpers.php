<?php

if (!function_exists('human_date')) {
    /**
     * Generate Human readable Date Format
     *
     * @param $date
     * @param string|null $format
     * @return string
     * @throws Exception
     */
    function human_date($date, string $format = null): string
    {
        $date_format = $format ?? config('app.date_format2');
        if ($date instanceof \Carbon\Carbon) {
            return $date->format($date_format);
        } else if (is_string($date)) {
            return \Carbon\Carbon::parse($date)->format($date_format);
        } else if (is_null($date)) {
            return '';
        } else {
            throw new \TypeError("Invalid date value expected(string/Carbon Object).\n Given " . var_dump($date));
        }
    }
}

if (!function_exists('money')) {
    /**
     * Display Number into money format
     *
     * @param $number
     * @param int $precision
     * @param string $decimal_separator
     * @param string $thousand_separator
     * @return string
     * @throws Exception
     */
    function money($number, int $precision = 2, string $decimal_separator = '.', string $thousand_separator = ','): string
    {
        if (is_numeric($number)) {
            return number_format($number, $precision, $decimal_separator, $thousand_separator);
        } else {
            throw new \TypeError("Invalid number value expected(float, integer).\n Given " . var_dump($number));
        }
    }
}

if (!function_exists('up_limit')) {
    /**
     * Get Max upload File Upload Limit
     *
     * @param bool $display
     * @param bool $safe_mode
     * @return float|int
     * @assume System Size unit is Megabyte(MB)
     */
    function up_limit(bool $display = false, bool $safe_mode = true)
    {
        $post_max_size = (int)ini_get('post_max_size');
        $upload_max_filesize = (int)ini_get('upload_max_filesize');

        \Illuminate\Support\Facades\Log::info("POST max size:" . $post_max_size . "\n UPLOAD max filesize:" . $upload_max_filesize);

        if ($safe_mode == true)
            $max_upload = min($post_max_size, $upload_max_filesize);
        else
            $max_upload = max($post_max_size, $upload_max_filesize);

        if ($display == true)
            return $max_upload . 'MB';
        else
            return ($max_upload * 1024);
    }
}

