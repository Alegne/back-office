<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\NiveauResource;
use App\Models\Niveau;
use Illuminate\Http\Request;

class NiveauController extends Controller
{
    use FilterTrait;

    public function filter(Request $request)
    {
        $niveaux = Niveau::withCount(['etudiants' => function ($query) use ($request) {

            $query = $this->contraintes($request, $query, false);

            # $query->withFilters(
            #     request()->input('prices', []),
            #     request()->input('categories', []),
            #     request()->input('manufacturers', [])
            # );
        }]);

        # dd($niveaux->toSql());

        return NiveauResource::collection($niveaux->get());
    }
}
