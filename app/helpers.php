<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('isActive')) {
    function isActive($route)
    {
        return Route::is($route) ? 'active' : '';
    }
}
