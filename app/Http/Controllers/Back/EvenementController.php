<?php

namespace App\Http\Controllers\Back;

use App\DataTables\EvenementDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\EvenementRequest;
use App\Models\Evenement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

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

        if($request->has('image') && $request->image) {
            $this->deleteImages($evenement);
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

        $this->deleteImages($evenement);

        return response()->json();
    }

    ### Manage upload image

    protected function getInputs($request)
    {
        $inputs = $request->except(['image']);

        # $inputs['active'] = $request->has('active');

        if($request->image) {
            $inputs['image'] = $this->saveImages($request);
        }

        # dd($inputs);

        return $inputs;
    }

    protected function saveImages($request)
    {
        $image = $request->file('image');

        # dd($image);

        if ($image->extension())
        {
            $name  = time() . '.' . $image->extension();
        } else {
            $name  = time() . '.' . $image->getClientOriginalExtension();
        }

        # $name  = time() . '.' . $image->extension();

        $img   = Image::make($image->path());

        # $img->resize(width, height);

        $img->resize(1800, 800)->encode()->save(public_path('/storage/images/') . $name);
        $img->widen(800)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        return $name;
    }

    protected function deleteImages($evenement)
    {
        File::delete([
            public_path('/storage/images/') . $evenement->image,
            public_path('/storage/images/thumbs/') . $evenement->image,
        ]);
    }
}
