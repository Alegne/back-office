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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $evenement = null;

        $types = ['actualite' => 'Actualite', 'nouvelle' => 'Nouvelle'];

        if ($request->ok)
        {
            # dd($request->ok);
            $ok = 'The post has been successfully created';
            return view('back.evenement.form', compact('evenement', 'types', 'ok'));
        }

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

        $evenement = Evenement::create($inputs);

        # return back()->with('ok', 'The post has been successfully created');
        return redirect()->route('evenement.galeries.view', ['evenement' => $evenement]);
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

        # return back()->with('ok', 'The post has been successfully updated');
        return redirect()->route('evenement.galeries.view', ['evenement' => $evenement]);
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

    /**
     * @param Evenement $evenement
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function galeriesView(Evenement $evenement)
    {
        return view('back.evenement.galerie', compact('evenement'));
    }

    /**
     * Upload Galeries
     *
     * @param Request $request
     * @param Evenement $evenement
     * @return \Illuminate\Http\JsonResponse
     */
    public function galeries(Request $request, Evenement $evenement)
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

        if ($evenement->galerie)
        {
            if (count($evenement->galerie) > 0)
            {
                $data = $data->merge($evenement->galerie);
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

        $evenement->galerie = $data->all();

        $evenement->save();

        return response()->json(['success' => $evenement]);
    }

    /**
     * Delete les pieces jointes
     *
     * @param Request $request
     * @param Evenement $evenement
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteGaleries(Request $request, Evenement $evenement)
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

        if ($evenement->galerie)
        {
            if (count($evenement->galerie) > 0)
            {
                foreach ($evenement->galerie as $piece)
                {
                    if ($piece != $filename)
                    {
                        $data->push($piece);
                    }
                }
            }
        }

        #$evenement->galerie = count($data) > 0 ? json_encode($data->all()) : null;
        $evenement->galerie = count($data) > 0 ? $data->all() : null;
        $evenement->save();

        return response()->json(['success' => $evenement]);
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

        $img->resize(1800,800)->encode()->save(public_path('/storage/images/') . $name);
        $img->resize(800,800)->encode()->save(public_path('/storage/images/thumbs/') . $name);

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
