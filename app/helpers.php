<?php
/**
 * Created by PhpStorm.
 * User: NRH
 * Date: 05/04/2021
 * Time: 18:46
 */

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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
    function getImage($model, $thumb = false, $directory = 'upload')
    {
        $id     = $model ? $model->user->id : 1;
        $image  = $model ? $model->image : 'image';

        # $url = "storage/photos/{$id}";
        $url = "storage/photos/{$directory}";

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


if (!function_exists('formatDateTime')) {
    function formatDateTime($date)
    {
        return $date->format('d-m-Y H:i:s');
        # return ucfirst(utf8_encode ($date->formatLocalized('%d %B %Y')));
    }
}

if (!function_exists('formatDateItem')) {
    function formatDateItem($date)
    {
        # dd(gettype($date));

        # $date = date($date);
        # return $date->format('d/m/Y');

        return Carbon::parse($date)->format('d/m/Y');

        #return date("dd-mm-YYYY", strtotime($date));
    }
}


if (!function_exists('formatDateEmploiTemps')) {
    function formatDateEmploiTemps($date)
    {
        # 2002-09-20  | yyyy-MM-dd
        # return $date->formatLocalized('%Y-%m-%d');

        # return utf8_encode ($date->format('d-m-Y'));
        return utf8_encode ($date->format('d-m-Y'))
            ;

        #return date("dd-mm-YYYY", strtotime($date));
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

        # return utf8_encode ($date->format('d-m-Y'));
        return utf8_encode ($date->format('Y-m-d'))
            ;

        #return date("dd-mm-YYYY", strtotime($date));
    }
}

if (!function_exists('resumerDescription')) {
    function resumerDescription($texte, $nombre = 10)
    {
        if (strlen($texte) > $nombre)
        {
            $texte = substr($texte, 0, $nombre);
            $position_espace = strrpos($texte, " ");
            $texte = substr($texte, 0, $position_espace);
            $texte .= '...';
            return $texte;
        }
        else return $texte;
    }
}

if (!function_exists('parseRouteActive')) {
    function parseRouteActive()
    {
        $route = Route::currentRouteName();

        $arrayRoute = explode('.', $route);

        $route = $arrayRoute[0] . '.' . 'create';

        return $route;
    }
}


if (!function_exists('parseRouteActiveSecond')) {
    function parseRouteActiveSecond()
    {
        $route = Route::currentRouteName();

        $arrayRoute = explode('.', $route);

        $route = $arrayRoute[1];

        if ($route == 'emploi_temps')
            $route = 'emploi_du_temps';

        # dd($route);

        $route = strtoupper(str_replace("_", " ", $route));

        return $route;
    }
}

if (!function_exists('getConfiguration')) {
    function getConfiguration($cle)
    {
        $configuration = \App\Models\Configuration::where('cle', $cle)->first();

        if (isset($configuration))
        {
            return $configuration->valeur;
        }

        return null;
    }
}

if (!function_exists('getImageSingle')) {
    function getImageSingle($image, $thumb = false)
    {
        # $url = "storage/images/{$image}";
        $url = "storage/images";

        if($thumb) $url .= '/thumbs';

        elseif ($thumb == 'card') $url .= '/thumbs';

        return asset("{$url}/{$image}");
    }
}

if (!function_exists('getFileMultiple')) {
    function getFileMultiple($files)
    {
        $data = collect();
        $url = '';
        $path_image   = "storage/images";
        $path_fichier = "storage/fichiers";

        # dd($files);
        if (isset($files))
        {
            foreach ($files as $file)
            {
                if (in_array(Str::lower(explode('.', $file)[1]), ['jpeg','pjpeg','png','gif','jpg']))
                {
                    $url = asset("{$path_image}/{$file}");
                } else {
                    $url = asset("{$path_fichier}/{$file}");
                }

                $data->push($url);
            }
        }


        return $data;
    }
}

if (!function_exists('uploadImageSingle')) {
    function uploadImageSingle()
    {

        return null;
    }
}

if (!function_exists('uploadImageMultiple')) {
    function uploadImageMultiple()
    {

        return null;
    }
}

if (!function_exists('uploadFileSingle')) {
    function uploadFileSingle()
    {

        return null;
    }
}

if (!function_exists('uploadFileMultiple')) {
    function uploadFileMultiple()
    {

        return null;
    }
}


/**
 * Espace MEMBRE
 */
if (!function_exists('getUtilisateur')) {
    function getUtilisateur(Request $request)
    {
        $data = null;

        if(session('espace_utlisateur'))
        {
            $data = json_decode(session('espace_utlisateur'));
        }

        if(!isset($data) && $request->cookie('espace_utlisateur'))
        {
            $data = json_decode($request->cookie('espace_utlisateur'));
        }

        return $data;
    }
}

