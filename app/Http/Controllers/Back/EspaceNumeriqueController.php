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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $espaceNumerique = null;

        $parcours    = Parcours::all()->pluck('tag', 'id');
        $niveaux     = Niveau::all()->pluck('tag', 'id');
        $enseignants = Enseignant::all()->pluck('nom', 'id');

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

        return back()->with('ok', 'The post has been successfully created');
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

        if($request->has('pieces_jointes') && $request->pieces_jointes) {
            # $this->deleteImages($enseignant);
        }

        $espaceNumerique->update($inputs);

        $espaceNumerique->parcours()->sync($request->parcours_id);

        return back()->with('ok', 'The post has been successfully updated');
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
        $espaceNumerique->delete();

        return response()->json();
    }

    protected function getInputs($request)
    {
        $inputs = $request->except(['pieces_jointes', 'MAX_FILE_SIZE', '_token', 'parcours_id']);

        # $inputs['active'] = $request->has('active');

        if($request->pieces_jointes) {
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

        foreach ($request->pieces_jointes as $jointe)
        {
            if ($jointe->extension())
            {
                $name  = time() . '.' . $jointe->extension();
            } else {
                $name  = time() . '.' . $jointe->getClientOriginalExtension();
            }


            # mimeType: "text/plain"

            # dd($jointe, $jointe->extension(), $name,
            #     $jointe->getClientOriginalName(), $jointe->getClientMimeType(),
            #     $jointe->getClientOriginalExtension());

            array_push($fichiers, $name);

            if (in_array($jointe->extension(), $extensions_images))
            {

                $img   = Image::make($jointe->path());
                $img->widen(800)->encode()->save(public_path('/storage/images/') . $name);
                $img->widen(400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

            }else{

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
