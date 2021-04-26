<?php

namespace App\Http\Controllers\Back;

use App\DataTables\AnnonceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\AnnonceRequest;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AnnonceDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(AnnonceDataTable $dataTable)
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
        $annonce = null;

        return view('back.annonce.form', compact('annonce'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AnnonceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnonceRequest $request)
    {
        $inputs = $this->getInputs($request);

        Annonce::create($inputs);

        return back()->with('ok', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function show(Annonce $annonce)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function edit(Annonce $annonce)
    {
        return view('back.annonce.form', compact('annonce'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AnnonceRequest $request
     * @param  \App\Models\Annonce $annonce
     * @return \Illuminate\Http\Response
     */
    public function update(AnnonceRequest $request, Annonce $annonce)
    {
        $inputs = $this->getInputs($request);

        if ($request->has('image') && $request->image) {
            $this->deleteImages($annonce);
        }

        $annonce->update($inputs);

        return back()->with('ok', 'Mise à jour a été un  succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annonce $annonce
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Annonce $annonce)
    {
        $annonce->delete();

        $this->deleteImages($annonce);

        return response()->json();
    }



    ### Manage upload image

    protected function getInputs($request)
    {
        $inputs = $request->except(['image']);

        # $inputs['active'] = $request->has('active');

        if ($request->image) {
            $inputs['image'] = $this->saveImages($request);
        }

        # dd($inputs);

        return $inputs;
    }

    protected function saveImages($request)
    {
        # dd($request->file('image'));

        $image = $request->file('image');
        $name  = time() . '.' . $image->extension();
        $img   = Image::make($image->path());

        # $img->resize(width, height);

        $img->widen(1000)->encode()->save(public_path('/storage/images/') . $name);
        $img->widen(400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        return $name;
    }

    protected function deleteImages($annonce)
    {
        File::delete([
            public_path('/storage/images/') . $annonce->image,
            public_path('/storage/images/thumbs/') . $annonce->image,
        ]);
    }
}
