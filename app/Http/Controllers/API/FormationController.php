<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\FormationResource;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    use FilterTrait;

    public function all()
    {
        /*$formations = Formation::
        #lastest('id')->
        # groupBy('libelle')->
        orderBy('id', 'ASC')
            ->get()
        ;*/

        return FormationResource::collection(Formation::all());
        # return FormationResource::collection($formations);
    }

    public function get(Formation $formation)
    {
        # return new FormationResource(Formation::findOrFail($id));
        return new FormationResource($formation);
    }

    public function filter(Request $request)
    {
        $formations = Formation::withCount(['etudiants' => function ($query) use ($request) {

            $query = $this->contraintes($request, $query, false);

            # $query->withFilters(
            #     request()->input('prices', []),
            #     request()->input('categories', []),
            #     request()->input('manufacturers', [])
            # );
        }])
        ;
        # dd($formations->toSql());

        return FormationResource::collection($formations->get());
    }
}
