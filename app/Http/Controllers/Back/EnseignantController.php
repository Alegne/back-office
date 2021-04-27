<?php

namespace App\Http\Controllers\Back;

use App\DataTables\EnseignantDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\EnseignantRequest;
use App\Http\Requests\Back\EtudiantRequest;
use App\Models\Enseignant;
use App\Notifications\NouveauCompte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class EnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param EnseignantDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(EnseignantDataTable $dataTable)
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
        $enseignant = null;

        return view('back.enseignant.form', compact('enseignant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EnseignantRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnseignantRequest $request)
    {
        $request->merge(['mot_de_passe' => Hash::make($request->mot_de_passe)]);

        $inputs = $this->getInputs($request);

        $enseignant = Enseignant::create($inputs);

        ### Notification
        $enseignant->notify(new NouveauCompte($enseignant->email, false, null, $enseignant->identifiant));

        return back()->with('ok', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enseignant  $enseignant
     * @return \Illuminate\Http\Response
     */
    public function show(Enseignant $enseignant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enseignant  $enseignant
     * @return \Illuminate\Http\Response
     */
    public function edit(Enseignant $enseignant)
    {
        return view('back.enseignant.form', compact('enseignant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EnseignantRequest $request
     * @param  \App\Models\Enseignant $enseignant
     * @return \Illuminate\Http\Response
     */
    public function update(EnseignantRequest $request, Enseignant $enseignant)
    {
        #dd($request->all());
        $request->merge(['mot_de_passe' => Hash::make($request->mot_de_passe)]);

        $inputs = $this->getInputs($request);

        if ($request->has('photo') && $request->photo) {
            $this->deleteImages($enseignant);
        }

        $enseignant->update($inputs);

        return back()->with('ok', 'The post has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enseignant $enseignant
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Enseignant $enseignant)
    {
        $enseignant->delete();
        $this->deleteImages($enseignant);

        return response()->json();
    }


    ### Manage upload image

    protected function getInputs($request)
    {
        $inputs = $request->except(['photo']);

        # $inputs['active'] = $request->has('active');

        #dd($request->file('photo'), $request->photo);

        if ($request->file('photo')) {
            $inputs['photo'] = $this->saveImages($request);
        }

        # dd($inputs);

        return $inputs;
    }

    protected function saveImages($request)
    {
        # dd($request->file('photo'), $request->photo);

        $image = $request->file('photo');
        $name  = time() . '.' . $image->extension();
        $img   = Image::make($image->path());

        # $img->resize(width, height);

        $img->widen(800)->encode()->save(public_path('/storage/images/') . $name);
        $img->widen(400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        return $name;
    }

    protected function deleteImages($enseignant)
    {
        File::delete([
            public_path('/storage/images/') . $enseignant->photo,
            public_path('/storage/images/thumbs/') . $enseignant->photo,
        ]);
    }
}
