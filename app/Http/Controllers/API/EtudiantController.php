<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\EtudiantResource;
use App\Models\Enseignant;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    public function info(Etudiant $etudiant)
    {
        return new EtudiantResource($etudiant);
    }
}
