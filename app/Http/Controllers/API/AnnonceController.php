<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\AnnonceResource;
use App\Models\Annonce;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    public function top()
    {
        $annonces = Annonce::latest('id', 'updated_at')->take(3)->get();

        return AnnonceResource::collection($annonces);
    }

    # pagination
    public function all(Request $request)
    {
        #dd('pagination', $request->has('niveau'));
        $annonces = Annonce::query();

        if ($request->has('niveau') && $request->niveau &&
            $request->has('parcours') && $request->parcours) {
            $niveaux = Niveau::where('tag', $request->niveau)->first();
            $parcours = Parcours::where('tag', $request->parcours)->first();

            $annonces = $annonces->whereHas('parcours', function ($q) use ($parcours) {
                    $q->where('cactus_parcours.tag', $parcours->tag);
                })
                ->whereHas('niveau', function ($q) use ($niveaux) {
                    $q->where('cactus_niveaux.tag', $niveaux->tag);
                })
                #->get()
            ;
        }

        $annonces = $annonces->latest('id', 'updated_at');

        $annonces = $request->pagination ?
            $annonces->paginate(10) :
            $annonces->get()
        ;

        return AnnonceResource::collection($annonces);

    }

    public function get(Annonce $annonce)
    {
        return new AnnonceResource($annonce);
    }
}
