<?php

namespace App\Http\Controllers\Back;

use App\DataTables\EvenementDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\EvenementRequest;
use App\Models\Evenement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param EvenementDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(EvenementDataTable $dataTable)
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
        $evenement = null;

        $types = ['actualite' => 'Actualite', 'nouvelle' => 'Nouvelle'];

        return view('back.evenement.form', compact('evenement', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EvenementRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EvenementRequest $request)
    {
        $merge = $request->merge(['date_creation' => Carbon::now()]);

        $inputs = $this->getInputs($merge);

        Evenement::create($inputs);

        return back()->with('ok', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evenement  $evenement
     * @return \Illuminate\Http\Response
     */
    public function show(Evenement $evenement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evenement  $evenement
     * @return \Illuminate\Http\Response
     */
    public function edit(Evenement $evenement)
    {
        $types = ['actualite' => 'Actualite', 'nouvelle' => 'Nouvelle'];

        return view('back.evenement.form', compact('evenement', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EvenementRequest $request
     * @param  \App\Models\Evenement $evenement
     * @return \Illuminate\Http\Response
     */
    public function update(EvenementRequest $request, Evenement $evenement)
    {
        $inputs = $this->getInputs($request);

        if($request->has('image')) {
            # $this->deleteImages($article);
        }

        $evenement->update($inputs);

        return back()->with('ok', 'The post has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evenement $evenement
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Evenement $evenement)
    {
        $evenement->delete();

        return response()->json();
    }


    protected function getInputs($request)
    {
        $inputs = $request->except(['image']);

        # $inputs['active'] = $request->has('active');

        if($request->photo) {
            $inputs['image'] = $this->saveImages($request);
        }

        return $inputs;
    }

    protected function saveImages($request)
    {
        $image = $request->file('image');
        $name  = time() . '.' . $image->extension();
        # $img   = InterventionImage::make($image->path());
        $img   = '';

        $img->widen(800)->encode()->save(public_path('/images/') . $name);
        $img->widen(400)->encode()->save(public_path('/images/thumbs/') . $name);

        return $name;
    }
}
