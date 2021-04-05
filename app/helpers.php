<?php
/**
 * Created by PhpStorm.
 * User: NRH
 * Date: 05/04/2021
 * Time: 18:46
 */

/**
 *  Helper use to Admin
 */
# Sidebar Admin
if (!function_exists('currentRouteActive')) {
    function currentRouteActive(...$routes)
    {
        foreach ($routes as $route) {
            if(Route::currentRouteNamed($route)) return 'active';
        }
    }
}

# Sidebar Admin
if (!function_exists('currentChildActive')) {
    function currentChildActive($children)
    {
        foreach ($children as $child) {
            if(Route::currentRouteNamed($child['route'])) return 'active';
        }
    }
}

# Sidebar Admin
if (!function_exists('menuOpen')) {
    function menuOpen($children)
    {
        foreach ($children as $child) {
            if(Route::currentRouteNamed($child['route'])) return 'menu-open';
        }
    }
}

# Sidebar Admin
if (!function_exists('isRole')) {
    function isRole($role)
    {
        return auth()->user()->role === $role;
    }
}
