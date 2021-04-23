<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\EspaceNumeriqueRequest;
use App\Http\Resources\API\EspaceNumeriqueResource;
use App\Models\AnneeUniversitaireLibelle;
use App\Models\Enseignant;
use App\Models\EspaceNumerique;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Http\Request;

class EspaceNumeriqueController extends Controller
{
    # Niveau | Parcours | Enseignant
    public function all(Request $request)
    {
        if ($request->has('niveau') && $request->niveau &&
            $request->has('parcours') && $request->parcours &&
            $request->has('annee') && $request->annee)
        {
            $niveau   = Niveau::where('tag', $request->niveau)->first();
            $parcours = Parcours::where('tag', $request->parcours)->first();
            $annee    = AnneeUniversitaireLibelle::where('libelle', $request->annee)->first();

            $espaceNumerique = EspaceNumerique::where('niveau_id', $niveau->id)
                # ->where('annee_id', $annee->id)
                ->whereHas('parcours', function ($q) use ($parcours) {
                    $q->where('cactus_parcours.tag', $parcours->tag);
                })
                ->latest('id', 'updated_at')
                ->get()
            ;

            return EspaceNumeriqueResource::collection($espaceNumerique);

        } elseif ($request->has('enseignant') && $request->enseignant)
        {
            $enseignant   = Enseignant::where('id', $request->enseignant)->first();

            $espaceNumerique = EspaceNumerique::where('enseignant_id', $enseignant->id)
                # ->where('annee_id', $annee->id)
                ->latest('id', 'updated_at')
                ->get()
            ;

            return EspaceNumeriqueResource::collection($espaceNumerique);
        }else {
            return response()->json(['message' => 'NOT FOUND']);
        }
    }

    public function get(EspaceNumerique $espaceNumerique)
    {
        return new EspaceNumeriqueResource($espaceNumerique);
    }

    # Sans Pieces Jointes
    public function post(EspaceNumeriqueRequest $request)
    {
        $inputs = $request->except(['parcours', 'niveau', 'enseignant']);

        $niveau   = Niveau::where('tag', $request->niveau)->first();
        $parcours = Parcours::where('tag', $request->parcours)->first();
        $enseignant = Enseignant::find($request->enseignant);

        $inputs['niveau_id']   = $niveau->id;
        $inputs['enseignant_id'] = $enseignant->id;

        $espaceNumerique = EspaceNumerique::create($inputs);

        $espaceNumerique->parcours()->attach($request->parcours_id);

        return new EspaceNumeriqueResource($espaceNumerique);
    }

    # Avec Pieces Jointes
    public function postPiecesJointes(EspaceNumeriqueRequest $request, EspaceNumerique $espaceNumerique)
    {
        return new EspaceNumeriqueResource($espaceNumerique);
    }
}
