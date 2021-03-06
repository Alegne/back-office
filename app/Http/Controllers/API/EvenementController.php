<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\EvenementResource;
use App\Models\Evenement;
use Illuminate\Http\Request;

class EvenementController extends Controller
{

    public function topActualite()
    {
        $articles = Evenement::where('type', 'actualite')->latest('updated_at')->take(3)->get();

        return EvenementResource::collection($articles);
    }

    public function topNouvelle()
    {
        $articles = Evenement::where('type', 'nouvelle')->latest('updated_at')->take(3)->get();

        return EvenementResource::collection($articles);
    }

    public function all(Request $request)
    {
        $evenements = Evenement::query()->latest('updated_at');

        $evenements = $request->pagination ?
            $evenements->paginate(10) :
            $evenements->get()
        ;
        return EvenementResource::collection($evenements);
    }

    public function get(Evenement $evenement)
    {
        return new EvenementResource($evenement);
    }
}
