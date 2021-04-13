<?php

namespace App\Http\Controllers\Back;

use App\DataTables\FormationDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\FormationRequest;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param FormationDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(FormationDataTable $dataTable)
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
        $formation = null;

        # Get an array with the values of a given key.
        # $categories = Category::all()->pluck('title', 'id');

        return view('back.formation.form', compact('formation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormationRequest $request)
    {
        # dd($request->all());

        $inputs = $this->getInputs($request);

        Formation::create($inputs);

        return back()->with('ok', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function show(Formation $formation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function edit(Formation $formation)
    {
        return view('back.formation.form', compact('formation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormationRequest $request
     * @param  \App\Models\Formation $formation
     * @return \Illuminate\Http\Response
     */
    public function update(FormationRequest $request, Formation $formation)
    {
        $inputs = $this->getInputs($request);

        if($request->has('photo')) {
            $this->deleteImages($formation);
        }

        $formation->update($inputs);

        return back()->with('ok', 'The post has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formation $formation
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Formation $formation)
    {
        $formation->delete();

        deleteImages($formation);

        return response()->json();
    }



    protected function getInputs($request)
    {
        $inputs = $request->except(['photo']);

        # $inputs['active'] = $request->has('active');

        if($request->photo) {
            $inputs['photo'] = $this->saveImages($request);
        }

        # dd($inputs);

        return $inputs;
    }

    protected function saveImages($request)
    {
        # dd($request->file('photo'));

        $image = $request->file('photo');
        $name  = time() . '.' . $image->extension();
        $img   = Image::make($image->path());

        # $img->resize(width, height);

        $img->widen(800)->encode()->save(public_path('/storage/images/') . $name);
        $img->widen(400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        return $name;
    }

    protected function deleteImages($formation)
    {
        File::delete([
            public_path('/storage/images/') . $formation->photo,
            public_path('/storage/images/thumbs/') . $formation->photo,
        ]);
    }
}
