<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\AnneeUniversitaireLibelle;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Niveau;
use App\Models\Parcours;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $etudiants_actif = Etudiant::where('status', 'actif')->count();
        $etudiants_ancien = Etudiant::where('status', 'ancien')->count();
        $users = User::count();
        $enseignants = Enseignant::count();

        $niveaux = Niveau::select('tag', DB::raw('count(*) as total'))
                            # ->whereHas('etudiants', function ($q) use ($request) {
                            #     $q->where('cactus_etudiants.status', 'actif');
                            # })
                            ->join('cactus_annee_universitaires', 'cactus_annee_universitaires.niveau_id', 'cactus_niveaux.id')
                            ->join('cactus_etudiants', 'cactus_annee_universitaires.etudiant_id', 'cactus_etudiants.id')
                            ->where('cactus_etudiants.status', 'actif')
                            ->groupBy('tag')
                            ->pluck('total','tag')->all()
        ;

        # dd($etudiants_actif, $etudiants_ancien, $users, $enseignants, $niveaux);

        $parcours = Parcours::select('tag', DB::raw('count(*) as total'))
                            ->join('cactus_etudiants', 'cactus_etudiants.parcours_id', 'cactus_parcours.id')
                            ->where('cactus_etudiants.status', 'actif')
                            ->groupBy('tag')
                            ->pluck('total','tag')->all();

        $annees = AnneeUniversitaireLibelle::
        select('libelle', DB::raw('count(*) as total'))
            ->join('cactus_annee_universitaires', 'cactus_annee_universitaires.annee_id', 'cactus_annee_universitaire_libelles.id')
            ->join('cactus_etudiants', 'cactus_annee_universitaires.etudiant_id', 'cactus_etudiants.id')
            ->where('cactus_etudiants.status', 'actif')
                                            ->groupBy('libelle')
                                            #->latest('updated')
                                            # ->latest('id')
                                            ->take(5)
                                            ->pluck('total','libelle')->all();

        if ($request->ajax())
        {
            return response()->json([
                'ancien'     => $etudiants_ancien,
                'actif'      => $etudiants_actif,
                'user'       => $users,
                'enseignant' => $enseignants,
                'niveaux'    => $niveaux,
                'parcours'   => $parcours,
                'annees'     => $annees,
            ]);
        }

        return view('back.index',
            compact('etudiants_ancien', 'etudiants_actif', 'users', 'enseignants', 'niveaux', 'parcours', 'annees'));
    }
}
