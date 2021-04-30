<?php

namespace App\Http\Controllers\Back;

use App\DataTables\FormationDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\FormationRequest;
use App\Models\Formation;
use App\Rules\GenericUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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

        return back()->with('ok', 'Enregistrement succès');
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
     * @param Request $request
     * @param  \App\Models\Formation $formation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Formation $formation)
    {
        $request->validate([
            'libelle'     => ['required', 'max:255', new GenericUpdate('cactus_formations', 'libelle',
                                                                    $request->libelle, $formation->id)],
            'description' => 'required',
        ]);

        $inputs = $this->getInputs($request);

        if ($request->has('photo') && $request->photo) {
            $this->deleteImages($formation);
        }

        $formation->update($inputs);

        return back()->with('ok', 'Mise à jour a été un  succès');
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
        try{
            $formation->delete();

            $this->deleteImages($formation);
        } catch (\Exception $e)
        {
            return response()->json([
                'ok'      => false,
                'message' => "Erreur de Suppresion, d'autres enregistrements dependent de cette formation " .  $formation->libelle
            ]);
        }

        return response()->json([
            'ok'      => true,
            'message' => "Success de Suppresion"
        ]);
    }

    ### Manage upload image

    protected function getInputs($request)
    {
        $inputs = $request->except(['photo']);

        # $inputs['active'] = $request->has('active');
        $inputs['slug'] = Str::slug(Str::random(25)) . Str::slug($request->libelle);

        if ($request->photo) {
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

        $img->resize(1000,800)->encode()->save(public_path('/storage/images/') . $name);
        $img->resize(400,400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

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
