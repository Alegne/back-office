<?php

namespace App\Http\Controllers\Back;

use App\DataTables\ParcoursDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\ParcoursRequest;
use App\Models\Parcours;
use Illuminate\Http\Request;

class ParcoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ParcoursDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ParcoursDataTable $dataTable)
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
        $parcours = null;

        return view('back.parcours.form', compact('parcours'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ParcoursRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParcoursRequest $request)
    {
        # $inputs = $this->getInputs($request);

        Parcours::create($request->all());

        return back()->with('ok', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parcours  $parcours
     * @return \Illuminate\Http\Response
     */
    public function show(Parcours $parcours)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parcours $parcours
     * @return \Illuminate\Http\Response
     */
    public function edit(Parcours $parcours)
    {
        return view('back.parcours.form', compact('parcours'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ParcoursRequest $request
     * @param  \App\Models\Parcours $parcours
     * @return \Illuminate\Http\Response
     */
    public function update(ParcoursRequest $request, Parcours $parcours)
    {
        $parcours->update($request->all());

        return back()->with('ok', 'The post has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parcours $parcours
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Parcours $parcours)
    {
        $parcours->delete();

        return response()->json();
    }
}
