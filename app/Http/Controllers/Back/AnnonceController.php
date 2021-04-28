<?php

namespace App\Http\Controllers\Back;

use App\DataTables\AnnonceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\AnnonceRequest;
use App\Models\Annonce;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $annonce = null;

        $parcours = Parcours::all()->pluck('tag', 'id');
        $niveaux  = Niveau::all()->pluck('tag', 'id');
        $types    = ['public' => 'Publique', 'private' => 'Prive'];

        if ($request->ok)
        {
            # dd($request->ok);
            $ok = 'The post has been successfully created';
            return view('back.annonce.form', compact('annonce', 'parcours', 'niveaux', 'types', 'ok'));
        }

        return view('back.annonce.form', compact('annonce', 'parcours', 'niveaux', 'types'));
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

        $annonce = Annonce::create($inputs);

        $annonce->niveau()->attach($request->niveau_id);
        $annonce->parcours()->attach($request->parcours_id);

        # return back()->with('ok', 'The post has been successfully created');
        return redirect()->route('annonce.galeries.view', ['annonce' => $annonce]);
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

        $parcours = Parcours::all()->pluck('tag', 'id');
        $niveaux  = Niveau::all()->pluck('tag', 'id');
        $types    = ['public' => 'Publique', 'private' => 'Prive'];

        return view('back.annonce.form', compact('annonce', 'parcours', 'niveaux', 'types'));
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
        # dd($request->all());

        $inputs = $this->getInputs($request);

        if($request->has('image') && $request->image) {
            $this->deleteImages($annonce);
        }

        $annonce->update($inputs);

        $annonce->niveau()->sync($request->niveau_id);
        $annonce->parcours()->sync($request->parcours_id);

        # return back()->with('ok', 'The post has been successfully updated');
        return redirect()->route('annonce.galeries.view', ['annonce' => $annonce]);
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

    public function approuve(Annonce $annonce)
    {
        $annonce->approuve = 1;
        $annonce->save();
        return response()->json(['message' => 'suceess']);
    }

    public function desapprouve(Annonce $annonce)
    {
        $annonce->approuve = 0;
        $annonce->save();
        return response()->json(['message' => 'suceess']);
    }

    /**
     * @param Annonce $annonce
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function galeriesView(Annonce $annonce)
    {
        return view('back.annonce.galerie', compact('annonce'));
    }

    /**
     * Upload Galeries
     *
     * @param Request $request
     * @param Annonce $annonce
     * @return \Illuminate\Http\JsonResponse
     */
    public function galeries(Request $request, Annonce $annonce)
    {
        $extensions_images = [
            'jpeg',
            'pjpeg',
            'png',
            'gif',
            'jpg',
            'PNG'
        ];

        $data = collect();

        if ($annonce->galerie)
        {
            if (count($annonce->galerie) > 0)
            {
                $data = $data->merge($annonce->galerie);
            }
        }

        $name = $request->file('file')->getClientOriginalName();

        if (in_array($request->file('file')->extension(), $extensions_images))
        {
            $img   = Image::make($request->file('file')->path());
            $img->resize(1000,800)->encode()->save(public_path('/storage/images/') . $name);
            $img->resize(400,400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        }else{

            # dd(public_path('/storage/fichiers/')); # D:\projet M1\WebCup\_projet\projet-back-office-webcup\public\/storage/fichiers/
            # dd(public_path('storage\fichiers'));  # D:\projet M1\WebCup\_projet\projet-back-office-webcup\public\storage\fichiers


            $request->file('file')->storeAs('public\fichiers', $name);
            # $jointe->move(public_path('storage\fichiers'), $name);

        }

        # array_push($data, $name);
        $data->push($name);

        # $annonce->galerie = json_encode($data->all());
        $annonce->galerie = $data->all();

        $annonce->save();

        return response()->json(['success' => $annonce]);
    }

    /**
     * Delete les Galeries
     *
     * @param Request $request
     * @param Annonce $annonce
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteGaleries(Request $request, Annonce $annonce)
    {

        $filename =  $request->get('filename');
        $data = collect();

        $extension = explode('.', $filename)[1];

        $extensions_images = [
            'jpeg',
            'pjpeg',
            'png',
            'gif',
            'jpg'
        ];

        if (in_array($extension, $extensions_images)){
            File::delete([
                public_path('/storage/images/') . $filename,
                public_path('/storage/images/thumbs/') . $filename,
            ]);
        }else{
            File::delete([
                public_path('/storage/fichiers/') . $filename,
            ]);
        }

        if ($annonce->galerie)
        {
            if (count($annonce->galerie) > 0)
            {
                foreach ($annonce->galerie as $piece)
                {
                    if ($piece != $filename)
                    {
                        $data->push($piece);
                    }
                }
            }
        }

        # $annonce->galerie = count($data) > 0 ? json_encode($data->all()) : null;
        $annonce->galerie = count($data) > 0 ? $data->all() : null;
        $annonce->save();

        return response()->json(['success' => $annonce]);
    }



    ### Manage upload image

    protected function getInputs($request)
    {
        $approuve = $request->approuve;

        $inputs = $request->except(['image', 'approuve']);

        if (isset($request->approuve))
        {
            $inputs['approuve'] = $request->approuve == 'on' ? 1 : 0;
        } else {
            $inputs['approuve'] = 0;
        }

        if($request->image) {
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

        $img->resize(1000, 800)->encode()->save(public_path('/storage/images/') . $name);
        $img->resize(400,400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

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
