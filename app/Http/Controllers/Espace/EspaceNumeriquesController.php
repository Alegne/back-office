<?php

namespace App\Http\Controllers\Espace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\EspaceNumeriqueRequest;
use App\Models\EspaceNumerique;
use App\Models\Etudiant;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class EspaceNumeriquesController extends Controller
{
    public function index(Request $request)
    {
        $utilisateur = getUtilisateur($request);
        $numeriques  = EspaceNumerique::query();
        $niveaux     = null;
        $parcours    = null;
        $show        = false;


        if ($utilisateur)
        {
            if (isset($utilisateur->identifiant))
            {
                $show = true;
                $numeriques = $numeriques
                    ->where('enseignant_id', $utilisateur->id)
                ;
            } else {

                $etudiant = Etudiant::find($utilisateur->id);

                # dd($etudiant->parcours->id, $etudiant->niveau, gettype($etudiant->niveau));

                $numeriques = $numeriques
                    ->where('niveau_id', $etudiant->niveau[0]->id)
                    /*->whereHas('parcours', function ($q) use ($etudiant) {
                        $q->where('cactus_parcours.id', $etudiant->parcours->id);
                    })*/
                ;

                $niveaux = $etudiant->niveau[0]->tag;
                $parcours = $etudiant->parcours->tag;
            }

            $numeriques = $numeriques->latest('updated_at');

            # dd($numeriques->get());
            # dd($numeriques->toSql());

            $numeriques = $numeriques->paginate(8);
            # $numeriques = $numeriques->get();

            return view('espace.espace_numeriques.index', compact('numeriques', 'niveaux', 'parcours', 'show'));
        }


        return redirect(config('front_office'));
    }

    public function show(EspaceNumerique $numerique)
    {
        return view('espace.espace_numeriques.show', compact('numerique'));
    }

    public function create(Request $request)
    {
        $parcours   = Parcours::all()->pluck('tag', 'id');
        $niveaux    = Niveau::all()->pluck('tag', 'id');
        $enseignant = null;


        $utilisateur = getUtilisateur($request);

        if ($utilisateur)
        {
            if (isset($utilisateur->identifiant))
            {
                $enseignant = $utilisateur->id;
            } else {
                # return redirect()->route('espace.espace_numerique.index');
            }
        }


        if ($request->ok) {
            # dd($request->ok);
            $ok = 'Enregistrement succès';
            return view('espace.espace_numeriques.create', compact('parcours', 'niveaux', 'ok', 'enseignant'));
        }

        return view('espace.espace_numeriques.create', compact('parcours', 'niveaux', 'enseignant'));
    }

    public function store(EspaceNumeriqueRequest $request)
    {
        # dd($request->all());

        $inputs = $this->getInputs($request);

        $numerique = EspaceNumerique::create($inputs);

        $numerique->parcours()->attach($request->parcours_id);

        return redirect()->route('espace.espace_numerique.pieces.view', ['numerique' => $numerique]);
    }


    public function piecesView(EspaceNumerique $numerique)
    {
        return view('espace.espace_numeriques.pieces', compact('numerique'));
    }

    public function pieces(Request $request, EspaceNumerique $numerique)
    {

        $extensions_images = [
            'jpeg',
            'pjpeg',
            'png',
            'gif',
            'jpg'
        ];

        # $data = [];
        $data = collect();
        # dd(count($data));
        # dd($espaceNumerique->pieces_jointes, gettype($espaceNumerique->pieces_jointes));


        if ($numerique->pieces_jointes) {
            if (count($numerique->pieces_jointes) > 0) {
                $data = $data->merge($numerique->pieces_jointes);
            }
        }

        $name = $request->file('file')->getClientOriginalName();

        if (in_array($request->file('file')->extension(), $extensions_images)) {
            $img   = Image::make($request->file('file')->path());

            $img->resize(1000, 800)->encode()->save(public_path('/storage/images/') . $name);
            $img->resize(400, 400)->encode()->save(public_path('/storage/images/thumbs/') . $name);
        } else {

            # dd(public_path('/storage/fichiers/')); # D:\projet M1\WebCup\_projet\projet-back-office-webcup\public\/storage/fichiers/
            # dd(public_path('storage\fichiers'));  # D:\projet M1\WebCup\_projet\projet-back-office-webcup\public\storage\fichiers


            $request->file('file')->storeAs('public\fichiers', $name);
            # $jointe->move(public_path('storage\fichiers'), $name);

        }

        # array_push($data, $name);
        $data->push($name);

        $numerique->pieces_jointes = json_encode($data->all());
        $numerique->save();

        return response()->json(['success' => $numerique]);
    }

    public function deletePieces(Request $request, EspaceNumerique $numerique)
    {
        $filename =  $request->get('filename');
        $data = collect();

        # dd($filename, explode('.', $filename));

        $extension = explode('.', $filename)[1];

        $extensions_images = [
            'jpeg',
            'pjpeg',
            'png',
            'gif',
            'jpg'
        ];

        if (in_array($extension, $extensions_images)) {
            File::delete([
                public_path('/storage/images/') . $filename,
                public_path('/storage/images/thumbs/') . $filename,
            ]);
        } else {
            File::delete([
                public_path('/storage/fichiers/') . $filename,
            ]);
        }


        if ($numerique->pieces_jointes) {
            if (count($numerique->pieces_jointes) > 0) {
                foreach ($numerique->pieces_jointes as $piece) {
                    if ($piece != $filename) {
                        $data->push($piece);
                    }
                }
            }
        }

        $numerique->pieces_jointes = count($data) > 0 ? json_encode($data->all()) : null;
        $numerique->save();

        return response()->json(['success' => $numerique]);
    }

    protected function getInputs($request)
    {
        $inputs = $request->except(['pieces_jointes', 'MAX_FILE_SIZE', '_token', 'parcours_id']);

        # $inputs['active'] = $request->has('active');

        if ($request->pieces_jointes) {
            $inputs['pieces_jointes'] = json_encode($this->saveFiles($request));
            # $inputs['pieces_jointes'] = $this->saveFiles($request);

            # $inputs['pieces_jointes'] = collect($this->saveFiles($request))->implode('|');
        }

        return $inputs;
    }
}
