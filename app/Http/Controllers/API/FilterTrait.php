<?php
/**
 * Created by PhpStorm.
 * User: NRH
 * Date: 23/04/2021
 * Time: 18:21
 */

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;

trait FilterTrait
{
    public function contraintes(Request $request, $query, $inclus = true)
    {
        if ($request->has('status') && $request->status)
        {
            $query->whereIn('status', $request->status);
        }

        if ($request->has('parcours') && $request->parcours)
        {
            $query->whereIn('parcours_id', $request->parcours);
        }

        if ($request->has('niveaux') && $request->niveaux)
        {
            # dd($request->niveaux, gettype($request->niveaux));

            $query->whereHas('niveau', function ($q) use ($request) {
                $q->whereIn('cactus_niveaux.tag', $request->niveaux);
            });
        }

        if ($request->has('annees') && $request->annees)
        {
            $query->whereHas('annee', function ($q) use ($request) {
                $q->whereIn('cactus_annee_universitaire_libelle.libelle', $request->annees);
            });
        }

        if ($request->has('formations') && $request->formations)
        {
            if ($inclus) {
                $query->join('cactus_annee_universitaires', 'cactus_annee_universitaires.etudiant_id', 'cactus_etudiants.id');
            }

            $query
                ->join('cactus_niveaux', 'cactus_annee_universitaires.niveau_id', 'cactus_niveaux.id')
                ->join('cactus_formations', 'cactus_formations.id', 'cactus_niveaux.formation_id')
                ->whereIn('cactus_formations.libelle', $request->formations)
                # ->select('cactus_etudiants.*', )
            ;
        }

        return $query;
    }
}
