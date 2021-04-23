<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\EtudiantResource;
use App\Http\Resources\API\EtuditantStatusResource;
use App\Models\Enseignant;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    use FilterTrait;

    public function info(Etudiant $etudiant)
    {
        return new EtudiantResource($etudiant);
    }

    public function filter(Request $request)
    {
        # dd($request->all());

        $query = Etudiant::query();

        $query = $this->contraintes($request, $query);

        # $etudiants = Etudiant::withFilters(
        #     request()->input('status', []),
        #     request()->input('parcours', [])
        # )
        #     ->get()
        # ;

        # dd($query->toSql());

        $etudiants = $query->get();

        # dd($etudiants);

        return EtudiantResource::collection($etudiants);
    }

    public function status(Request $request)
    {
        # $query = Etudiant::count()->where('parcours_id', 1);

        # dd($query);

        $query = Etudiant::query();

        $query = $this->contraintes($request, $query);

        # dd($query->toSql());

        $etudiants = $query
            # ->count()->groupBy('status')
            ->groupBy('status')->select('status', DB::raw('count(*) as etudiants_count'))->get()
            ;

        # dd($etudiants);

        # return new EtuditantStatusResource($etudiants);
        return EtuditantStatusResource::collection($etudiants);
    }
}
