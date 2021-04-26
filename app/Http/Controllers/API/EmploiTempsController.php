<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\EmploiTempsResource;
use App\Models\AnneeUniversitaireLibelle;
use App\Models\Calendar;
use App\Models\EmploiTemps;
use App\Models\EmploiTempsItem;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Http\Request;

class EmploiTempsController extends Controller
{
    # Niveau | Parcours | Annee | pagination
    public function all(Request $request)
    {
        if ($request->has('niveau') && $request->niveau &&
            $request->has('parcours') && $request->parcours &&
            $request->has('annee') && $request->annee)
        {
            $niveau   = Niveau::where('tag', $request->niveau)->first();
            $parcours = Parcours::where('tag', $request->parcours)->first();
            $annee    = AnneeUniversitaireLibelle::where('libelle', $request->annee)->first();

            $emploiTemps = EmploiTemps::where('niveau_id', $niveau->id)
                                ->where('annee_id', $annee->id)
                                ->whereHas('parcours', function ($q) use ($parcours) {
                                    $q->where('cactus_parcours.tag', $parcours->tag);
                                })
                                ->latest('id')
                                # ->paginate()
                                # ->get()
            ;

            $emploiTemps = $request->pagination ?
                            $emploiTemps->paginate(10) :
                            $emploiTemps->get()
            ;

            return EmploiTempsResource::collection($emploiTemps);

        } elseif ($request->has('enseignant') && $request->enseignant)
        {
            /*$enseignant   = Enseignant::where('id', $request->enseignant)->first();

            $emploiTemps = EmploiTemps::where('enseignant_id', $enseignant->id)
                            # ->where('annee_id', $annee->id)
                            ->latest('id', 'updated_at')
                            # ->get()
            ;*/

            $emploiTemps = $request->pagination ?
                            EmploiTemps::paginate(10) :
                            EmploiTemps::get()
            ;

            return EmploiTempsResource::collection($emploiTemps);
        } else{
            return response()->json(['message' => 'NOT FOUND']);
        }

    }

    # id Emploi du temps
    public function get(Request $request, $id)
    {
        $items = EmploiTempsItem::where('emploi_du_temps_id', $id)
                    ->get()
                    ;

        $tab = [];

        foreach ($items as $item)
        {
            $enseignant = Enseignant::find($item->matiere->enseignant_id);
            $matiere = Matiere::find($item->matiere_id);

            $calendar = new Calendar(
                $item->id,
                $item->matiere->libelle . ' : ' . $enseignant->nom . ' ' . $enseignant->prenom,
                $item->heure_debut,
                $item->heure_fin,
                $item->matiere->couleur,
                $item->matiere->libelle,
                json_encode($matiere->parcours->pluck('tag')));

            array_push($tab, $calendar);
        }

        # dd($tab);
        return response()->json($tab);
    }
}
