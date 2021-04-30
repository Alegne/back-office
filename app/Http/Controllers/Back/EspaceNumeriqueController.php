<?php

namespace App\Http\Controllers\Back;

use App\DataTables\EspaceNumeriqueDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\EspaceNumeriqueRequest;
use App\Models\Enseignant;
use App\Models\EspaceNumerique;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class EspaceNumeriqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param EspaceNumeriqueDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(EspaceNumeriqueDataTable $dataTable)
    {
        return $dataTable->render('back.shared.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $espaceNumerique = null;

        $parcours    = Parcours::all()->pluck('tag', 'id');
        $niveaux     = Niveau::all()->pluck('tag', 'id');
        $enseignants = Enseignant::all()->pluck('nom', 'id');

        if ($request->ok) {
            # dd($request->ok);
            $ok = 'Enregistrement succès';
            return view('back.ent.form', compact('espaceNumerique', 'parcours', 'niveaux', 'enseignants', 'ok'));
        }

        return view('back.ent.form', compact('espaceNumerique', 'parcours', 'niveaux', 'enseignants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EspaceNumeriqueRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EspaceNumeriqueRequest $request)
    {
        # dd($request->all());

        # $request->pieces_jointes

        $inputs = $this->getInputs($request);

        $espace = EspaceNumerique::create($inputs);

        $espace->parcours()->attach($request->parcours_id);


        # return back()->with('ok', 'Enregistrement succès');
        return redirect()->route('espace-numerique-travail.pieces.view', ['espaceNumerique' => $espace]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EspaceNumerique  $espaceNumerique
     * @return \Illuminate\Http\Response
     */
    public function show(EspaceNumerique $espaceNumerique)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EspaceNumerique  $espaceNumerique
     * @return \Illuminate\Http\Response
     */
    public function edit(EspaceNumerique $espaceNumerique)
    {
        $parcours    = Parcours::all()->pluck('tag', 'id');
        $niveaux     = Niveau::all()->pluck('tag', 'id');
        $enseignants = Enseignant::all()->pluck('nom', 'id');

        # dd($espaceNumerique, $espaceNumerique->pieces_jointes,
        #     $espaceNumerique->pieces_jointes[0],
        #     explode('.', $espaceNumerique->pieces_jointes[0])[1]);

        return view('back.ent.form', compact('espaceNumerique', 'parcours', 'niveaux', 'enseignants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EspaceNumerique  $espaceNumerique
     * @return \Illuminate\Http\Response
     */
    public function update(EspaceNumeriqueRequest $request, EspaceNumerique $espaceNumerique)
    {
        $inputs = $this->getInputs($request);

        if ($request->has('pieces_jointes') && $request->pieces_jointes) {
            # $this->deleteImages($enseignant);
        }

        $espaceNumerique->update($inputs);

        $espaceNumerique->parcours()->sync($request->parcours_id);

        # return back()->with('ok', 'Mise à jour a été un  succès');
        return redirect()->route('espace-numerique-travail.pieces.view', ['espaceNumerique' => $espaceNumerique]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EspaceNumerique $espaceNumerique
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(EspaceNumerique $espaceNumerique)
    {
        try{
            $espaceNumerique->delete();

        } catch (\Exception $e)
        {
            return response()->json([
                'ok'      => false,
                'message' => "Erreur de Suppresion, d'autres enregistrements dependent de cet espace numerique " .  $espaceNumerique->libelle
            ]);
        }

        return response()->json([
            'ok'      => true,
            'message' => "Success de Suppresion"
        ]);
    }

    public function piecesJointesView(EspaceNumerique $espaceNumerique)
    {
        return view('back.ent.pieces_jointes', compact('espaceNumerique'));
    }

    /**
     * Upload Pieces Jointes
     *
     * @param Request $request
     * @param EspaceNumerique $espaceNumerique
     * @return \Illuminate\Http\JsonResponse
     */
    public function piecesJointes(Request $request, EspaceNumerique $espaceNumerique)
    {
        # dd($request->all(), $espaceNumerique);

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


        if ($espaceNumerique->pieces_jointes) {
            if (count($espaceNumerique->pieces_jointes) > 0) {
                $data = $data->merge($espaceNumerique->pieces_jointes);
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

        $espaceNumerique->pieces_jointes = json_encode($data->all());
        $espaceNumerique->save();

        return response()->json(['success' => $espaceNumerique]);
    }

    /**
     * Delete les pieces jointes
     *
     * @param Request $request
     * @param EspaceNumerique $espaceNumerique
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePiecesJointes(Request $request, EspaceNumerique $espaceNumerique)
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


        if ($espaceNumerique->pieces_jointes) {
            if (count($espaceNumerique->pieces_jointes) > 0) {
                foreach ($espaceNumerique->pieces_jointes as $piece) {
                    if ($piece != $filename) {
                        $data->push($piece);
                    }
                }
            }
        }

        $espaceNumerique->pieces_jointes = count($data) > 0 ? json_encode($data->all()) : null;
        $espaceNumerique->save();

        return response()->json(['success' => $espaceNumerique]);
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

    protected function saveFiles($request)
    {
        # $request->pieces_jointes

        $fichiers = [];

        $extensions_images = [
            'jpeg',
            'pjpeg',
            'png',
            'gif',
            'jpg'
        ];

        # dd($request->pieces_jointes);

        foreach ($request->pieces_jointes as $jointe) {
            if ($jointe->extension()) {
                $name  = time() . '.' . $jointe->extension();
            } else {
                $name  = time() . '.' . $jointe->getClientOriginalExtension();
            }


            # mimeType: "text/plain"

            # dd($jointe, $jointe->extension(), $name,
            #     $jointe->getClientOriginalName(), $jointe->getClientMimeType(),
            #     $jointe->getClientOriginalExtension());

            array_push($fichiers, $name);

            if (in_array($jointe->extension(), $extensions_images)) {

                $img   = Image::make($jointe->path());

                $img->resize(1000, 800)->encode()->save(public_path('/storage/images/') . $name);
                $img->resize(400, 400)->encode()->save(public_path('/storage/images/thumbs/') . $name);
            } else {


                # dd(public_path('/storage/fichiers/')); # D:\projet M1\WebCup\_projet\projet-back-office-webcup\public\/storage/fichiers/
                # dd(public_path('storage\fichiers'));  # D:\projet M1\WebCup\_projet\projet-back-office-webcup\public\storage\fichiers


                $jointe->storeAs('public\fichiers', $name);
                # $jointe->move(public_path('storage\fichiers'), $name);


            }
        }

        # dd($fichiers);

        return $fichiers;
    }
}
