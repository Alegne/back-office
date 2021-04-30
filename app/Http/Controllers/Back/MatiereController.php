<?php

namespace App\Http\Controllers\Back;

use App\DataTables\MatiereDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\MatiereRequest;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\Parcours;
use App\Rules\GenericUpdate;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param MatiereDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(MatiereDataTable $dataTable)
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
        $matiere = null;

        $parcours = Parcours::all()->pluck('tag', 'id');
        $niveaux = Niveau::all()->pluck('tag', 'id');
        $enseignants = Enseignant::all()->pluck('nom', 'id');

        return view('back.matiere.form', compact('matiere', 'parcours', 'niveaux', 'enseignants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MatiereRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MatiereRequest $request)
    {
        # dd($request->all());
        # $inputs = $this->getInputs($request);

        $matiere = Matiere::create($request->all());

        $matiere->parcours()->attach($request->parcours_id);



        return back()->with('ok', 'Enregistrement succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function show(Matiere $matiere)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit(Matiere $matiere)
    {
        $parcours = Parcours::all()->pluck('tag', 'id');
        $niveaux = Niveau::all()->pluck('tag', 'id');
        $enseignants = Enseignant::all()->pluck('nom', 'id');

        return view('back.matiere.form', compact('matiere', 'parcours', 'niveaux', 'enseignants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Matiere $matiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matiere $matiere)
    {
        $request->validate([
            'libelle'        => ['required', new GenericUpdate('cactus_matieres', 'libelle',
                                                                    $request->libelle, $matiere->id)],
            'couleur'        => 'required',
            'enseignant_id'  => 'required',
            'niveau_id'      => 'required',
        ]);

        $matiere->update($request->all());

        $matiere->parcours()->sync($request->parcours_id);

        return back()->with('ok', 'Mise à jour a été un  succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matiere $matiere
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Matiere $matiere)
    {
        try{
            $matiere->delete();
        } catch (\Exception $e)
        {
            return response()->json([
                'ok'      => false,
                'message' => "Erreur de Suppresion, d'autres enregistrements dependent de cette matiere " .  $matiere->libelle
            ]);
        }

        return response()->json([
            'ok'      => true,
            'message' => "Success de Suppresion"
        ]);
    }
}
