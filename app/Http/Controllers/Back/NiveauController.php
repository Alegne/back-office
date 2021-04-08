<?php

namespace App\Http\Controllers\Back;

use App\DataTables\NiveauDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\NiveauRequest;
use App\Models\Formation;
use App\Models\Niveau;
use Illuminate\Http\Request;

class NiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param NiveauDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(NiveauDataTable $dataTable)
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
        $niveau = null;

        # Get an array with the values of a given key.
        $formations = Formation::all()->pluck('libelle', 'id');

        return view('back.niveau.form', compact('niveau', 'formations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NiveauRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NiveauRequest $request)
    {
        $niveau = Niveau::create($request->all());
        # $niveau->formation()->sync($request->formation);

        return back()->with('ok', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Niveau  $niveau
     * @return \Illuminate\Http\Response
     */
    public function show(Niveau $niveau)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Niveau  $niveau
     * @return \Illuminate\Http\Response
     */
    public function edit(Niveau $niveau)
    {
        # Get an array with the values of a given key.
        $formations = Formation::all()->pluck('libelle', 'id');

        return view('back.niveau.form', compact('niveau', 'formations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NiveauRequest $request
     * @param  \App\Models\Niveau $niveau
     * @return \Illuminate\Http\Response
     */
    public function update(NiveauRequest $request, Niveau $niveau)
    {
        $niveau->update($request->all());
        # $niveau->formation()->sync($request->formation);

        return back()->with('ok', 'The post has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Niveau $niveau
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Niveau $niveau)
    {
        $niveau->delete();

        return response()->json();
    }
}
