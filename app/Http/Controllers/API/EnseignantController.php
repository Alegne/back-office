<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\EnseignantResource;
use App\Models\Enseignant;
use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    public function info(Enseignant $enseignant)
    {
        return new EnseignantResource($enseignant);
    }
}
