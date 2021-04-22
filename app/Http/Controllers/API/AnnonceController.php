<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\AnnonceResource;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    public function top()
    {
        $annonces = Annonce::latest('id', 'updated_at')->take(3)->get();

        return AnnonceResource::collection($annonces);
    }

    public function all()
    {
        return AnnonceResource::collection(Annonce::all());
    }

    public function get(Annonce $annonce)
    {
        return new AnnonceResource($annonce);
    }
}
