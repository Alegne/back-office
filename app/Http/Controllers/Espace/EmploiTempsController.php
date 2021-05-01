<?php

namespace App\Http\Controllers\Espace;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\EmploiTemps;
use App\Models\EmploiTempsItem;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Http\Request;

class EmploiTempsController extends Controller
{
    public function index(Request $request)
    {
        $utilisateur = getUtilisateur($request);

        $emploiTemps = EmploiTemps::query();

        if ($utilisateur) {

            if (!isset($utilisateur->identifiant)) {

                if ($utilisateur->status == 'actif') {

                    $etudiant = Etudiant::find($utilisateur->id);

                    # $niveaux = Niveau::whereIn('tag', $utilisateur->niveau)->first();
                    # $parcours = Parcours::whereIn('tag', $utilisateur->parcours)->first();

                    $niveaux = Niveau::whereIn('id', $etudiant->niveau->pluck('id'))->get(); # Collection
                    $parcours = Parcours::where('id', $etudiant->parcours->id)->first();     # Object



                    $emploiTemps = $emploiTemps->whereHas('parcours', function ($q) use ($parcours) {
                        # $q->where('cactus_parcours.tag', $parcours->tag);
                        $q->where('cactus_parcours.id', $parcours->id);
                    })
                        # ->where('niveau_id', $niveaux->id)
                        ->where('niveau_id', $niveaux[0]->id)
                        #->get()
                    ;
                }
            }


            $emploiTemps = $emploiTemps->latest('updated_at');

            # dd($emploiTemps->toSql());

            $emploiTemps = $emploiTemps->paginate(8);
            # $annonces = $annonces->get();

            return view('espace.emploi_temps.index', compact('emploiTemps'));
        }

        return redirect(config('app.front_office'));
    }

    public function show(Request $request, EmploiTemps $emploiTemps)
    {
        if ($request->ajax() or $request->ajax == 1) {

            $items = EmploiTempsItem::where('emploi_du_temps_id', $emploiTemps->id)->get();

            # dd($items);

            $tab = [];

            foreach ($items as $item) {
                $enseignant = Enseignant::find($item->matiere->enseignant_id);
                $matiere    = Matiere::find($item->matiere_id);

                $calendar = new Calendar(
                    $item->id,
                    $item->matiere->libelle . ' : ' . $enseignant->nom . ' ' . $enseignant->prenom,
                    $item->heure_debut,
                    $item->heure_fin,
                    $item->matiere->couleur,
                    $item->matiere_id,
                    json_encode($matiere->parcours->pluck('tag'))
                );

                array_push($tab, $calendar);
            }

            # dd($tab);
            return response()->json($tab);
        }
        return view('espace.emploi_temps.show', compact('emploiTemps'));
    }
}
