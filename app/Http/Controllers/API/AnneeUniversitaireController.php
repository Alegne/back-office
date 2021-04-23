<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\AnneeUnviversitaireResource;
use App\Models\AnneeUniversitaireLibelle;
use Illuminate\Http\Request;

class AnneeUniversitaireController extends Controller
{

    use FilterTrait;

    public function filter(Request $request)
    {
        $annees = AnneeUniversitaireLibelle::withCount(['etudiants' => function ($query) use ($request) {

            $query = $this->contraintes($request, $query, false);

            # $query->withFilters(
            #     request()->input('prices', []),
            #     request()->input('categories', []),
            #     request()->input('manufacturers', [])
            # );
        }])
        ;
        # dd($annees->toSql());

        return AnneeUnviversitaireResource::collection($annees->get());
    }
}
