<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function get()
    {
        $configurations = Configuration::all();

        $data = [];

        foreach ($configurations as $configuration)
        {
            if ($configuration->cle == 'image_directeur')
            {
                array_push($data, [
                    'cle'    => $configuration->cle,
                    'valeur' => getImageSingle($configuration->valeur)
                ]);
            } else {
                array_push($data, [
                    'cle'    => $configuration->cle,
                    'valeur' => $configuration->valeur
                ]);
            }
        }

        # dd($data);

        return response()->json($data);
    }
}
