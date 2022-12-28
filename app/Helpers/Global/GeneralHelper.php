<?php

use Carbon\Carbon;

if (! function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return config('app.name', 'Laravel Boilerplate');
    }
}

if (! function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     *
     * @return Carbon
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}

if (! function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (auth()->check()) {
            return 'admin.dashboard';
            // if (auth()->user()->isAdmin()) {
            //     return 'admin.dashboard';
            // }

            // if (auth()->user()->isUser()) {
            //     return 'frontend.user.dashboard';
            // }
        }

        return 'frontend.index';
    }
}

if (! function_exists('renameCamelCase')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function renameCamelCase($val)
    {
        return ltrim(preg_replace('/(?<!\ )[A-Z]/', ' $0', $val));
    }
}

if (! function_exists('renameLegalName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function renameLegalName($val)
    {
        return strtolower(preg_replace('/\s*/', '', $val));
    }
}