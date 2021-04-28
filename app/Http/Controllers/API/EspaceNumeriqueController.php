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
use Intervention\Image\Facades\Image;

class EspaceNumeriqueController extends Controller
{
    # Niveau | Parcours | Enseignant
    public function all(Request $request)
    {
        if ($request->has('niveau') && $request->niveau &&
            $request->has('parcours') && $request->parcours )
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
                #->get()
            ;

            $espaceNumerique = $request->pagination ?
                                $espaceNumerique->paginate(10) :
                                $espaceNumerique->get()
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

        $espaceNumerique->parcours()->attach($parcours->id);

        return new EspaceNumeriqueResource($espaceNumerique);
    }

    # Avec Pieces Jointes
    public function postPiecesJointes(EspaceNumeriqueRequest $request, EspaceNumerique $espaceNumerique)
    {
        $extensions_images = [
            'jpeg',
            'pjpeg',
            'png',
            'gif',
            'jpg'
        ];

        $data = collect();

        if (count($espaceNumerique->pieces_jointes) > 0)
        {
            $data = $data->merge($espaceNumerique->pieces_jointes);
        }

        $name = $request->file('file')->getClientOriginalName();

        if (in_array($request->file('file')->extension(), $extensions_images))
        {
            $img   = Image::make($request->file('file')->path());
            $img->widen(800)->encode()->save(public_path('/storage/images/') . $name);
            $img->widen(400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        }else{
            $request->file('file')->storeAs('public\fichiers', $name);

        }

        $data->push($name);

        $espaceNumerique->pieces_jointes = json_encode($data->all());
        $espaceNumerique->save();

        return response()->json(['success' => $espaceNumerique]);
    }
}
