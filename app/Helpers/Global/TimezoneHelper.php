<?php

use Carbon\Carbon;
use JamesMills\LaravelTimezone\Timezone;

if (! function_exists('timezone')) {
    /**
     * Access the timezone helper.
     */
    function timezone()
    {
        return resolve(Timezone::class);
    }
}

if (! function_exists('convertDate')) {
    /**
     * convertDate
     */
    function convertDate($date, $tz = null)
    {
        if (isset($tz)) return Carbon::parse($date)->setTimezone($tz)->format('d/m/Y');
        return Carbon::parse($date)->format('d/m/Y');
    }
}
