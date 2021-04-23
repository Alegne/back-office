<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ParcoursResource;
use App\Models\Parcours;
use Illuminate\Http\Request;

class ParcoursController extends Controller
{
    use FilterTrait;

    public function filter(Request $request)
    {
        $parcours = Parcours::withCount(['etudiants' => function ($query) use ($request) {

            $query = $this->contraintes($request, $query);

            # $query->withFilters(
            #     request()->input('prices', []),
            #     request()->input('categories', []),
            #     request()->input('manufacturers', [])
            # );
        }])

        ;

        return ParcoursResource::collection($parcours->get());
    }
}
