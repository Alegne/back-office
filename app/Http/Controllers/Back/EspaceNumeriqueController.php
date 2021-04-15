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
        $inputs = $this->getInputs($request);

        $espace = EspaceNumerique::create($inputs);

        # $etudiant = EspaceNumerique::create($request->all());

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

        if($request->has('photo')) {
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
        $inputs = $request->except(['photo']);

        # $inputs['active'] = $request->has('active');

        if($request->photo) {
            $inputs['photo'] = $this->saveImages($request);
        }

        return $inputs;
    }

    protected function saveImages($request)
    {
        $image = $request->file('photo');
        $name  = time() . '.' . $image->extension();
        # $img   = InterventionImage::make($image->path());
        $img   = '';

        $img->widen(800)->encode()->save(public_path('/images/') . $name);
        $img->widen(400)->encode()->save(public_path('/images/thumbs/') . $name);

        return $name;
    }
}
