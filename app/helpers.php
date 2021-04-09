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

# Image
if (!function_exists('getImage')) {
    function getImage($model, $thumb = false)
    {
        $id     = $model ? $model->user->id : 1;
        $image  = $model ? $model->image : 'image';

        $url = "storage/photos/{$id}";

        if($thumb) $url .= '/thumbs';

        return asset("{$url}/{$image}");
    }
}

# Formatage date  | 20 September 2002
if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return ucfirst(utf8_encode ($date->formatLocalized('%d %B %Y')));
    }
}

# Formatage date  | 20/02/2002
# 'date_format' => 'm/d/Y',
# 'date_format_javascript' => 'MM/DD/YYYY',
if (!function_exists('formatDateChiffre')) {
    function formatDateChiffre($date)
    {
        # 2002-09-20  | yyyy-MM-dd
        # return $date->formatLocalized('%Y-%m-%d');

        return $date->format('d-m-Y');

        #return date("dd-mm-YYYY", strtotime($date));
    }
}
