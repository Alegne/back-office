<?php

namespace App\Http\Controllers\Back;

use App\DataTables\AnneeUniversitaireLibelleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\AnneeUniversitaireLibelleRequest;
use App\Models\AnneeUniversitaireLibelle;
use App\Models\Formation;
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

        return back()->with('ok', 'The post has been successfully created');
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
     * @param AnneeUniversitaireLibelleRequest $request
     * @param AnneeUniversitaireLibelle $annee
     * @return \Illuminate\Http\Response
     */
    public function update(AnneeUniversitaireLibelleRequest $request, AnneeUniversitaireLibelle $annee)
    {
        $annee->update($request->all());

        return back()->with('ok', 'The post has been successfully updated');
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
        $annee->delete();

        return response()->json();
    }
}
