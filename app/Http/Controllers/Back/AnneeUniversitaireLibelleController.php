<?php

namespace App\Http\Controllers\Back;

use App\DataTables\AnneeUniversitaireLibelleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\AnneeUniversitaireLibelleRequest;
use App\Models\AnneeUniversitaireLibelle;
use App\Models\Formation;
use App\Rules\AnneeUniversitaireUpdate;
use Illuminate\Http\Request;

class AnneeUniversitaireLibelleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AnneeUniversitaireLibelleDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(AnneeUniversitaireLibelleDataTable $dataTable)
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
        $annee = null;

        return view('back.annee.form', compact('annee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AnneeUniversitaireLibelleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnneeUniversitaireLibelleRequest $request)
    {
        AnneeUniversitaireLibelle::create($request->all());

        return back()->with('ok', 'Enregistrement succès');
    }

    /**
     * Display the specified resource.
     *
     * @param AnneeUniversitaireLibelle $annee
     * @return void
     */
    public function show(AnneeUniversitaireLibelle $annee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AnneeUniversitaireLibelle $annee
     * @return \Illuminate\Http\Response
     */
    public function edit(AnneeUniversitaireLibelle $annee)
    {
        return view('back.annee.form', compact('annee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AnneeUniversitaireLibelle $annee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnneeUniversitaireLibelle $annee)
    {
        $request->validate([
            'libelle'        => ['required', new AnneeUniversitaireUpdate($request->libelle, $annee->id)]
        ]);

        $annee->update($request->all());

        return back()->with('ok', 'Mise à jour a été un  succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AnneeUniversitaireLibelle $annee
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(AnneeUniversitaireLibelle $annee)
    {

        try{
            # Supprimer Annee Universitaire
            $annee->delete();

        } catch (\Exception $e)
        {
            return response()->json([
                'ok'      => false,
                'message' => "Erreur de Suppresion, d'autres enregistrements dependent de cet annee universitaire " .  $annee->libelle
            ]);
        }

        return response()->json([
            'ok'      => true,
            'message' => "Success de Suppresion"
        ]);
    }
}
