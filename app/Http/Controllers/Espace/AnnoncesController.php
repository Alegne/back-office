<?php

namespace App\Http\Controllers\Espace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\AnnonceRequest;
use App\Http\Resources\API\AnnonceResource;
use App\Models\Annonce;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AnnoncesController extends Controller
{
    public function index(Request $request)
    {
        $utilisateur = getUtilisateur($request);

        $annonces = Annonce::query()
            ->where('type', 'public')
        ;

        if ($utilisateur)
        {
            if ($utilisateur->status == 'actif')
            {
                $annonces = Annonce::query();

                $niveaux = Niveau::whereIn('tag', $utilisateur->niveau)->first();
                $parcours = Parcours::whereIn('tag', $utilisateur->parcours)->first();

                $annonces = $annonces->whereHas('parcours', function ($q) use ($parcours) {
                    $q->where('cactus_parcours.tag', $parcours->tag);
                })
                    ->whereHas('niveau', function ($q) use ($niveaux) {
                        $q->where('cactus_niveaux.tag', $niveaux->tag);
                    })
                    #->get()
                ;
            }

            $annonces = $annonces->latest('updated_at');

            # dd($annonces->toSql());

            $annonces = $annonces->paginate(8);
            # $annonces = $annonces->get();

            return view('espace.annonces.index', compact('annonces'));
        }

        return redirect(config('front_office'));

    }

    public function show(Request $request,  Annonce $annonce)
    {
        if ($request->ajax())
        {
            return new AnnonceResource($annonce);
        }

        return view('espace.annonces.show', compact('annonce'));
    }

    public function create(Request $request)
    {
        $parcours = Parcours::all()->pluck('tag', 'id');
        $niveaux  = Niveau::all()->pluck('tag', 'id');
        $types    = ['public' => 'Publique', 'private' => 'Prive'];

        if ($request->ok) {
            # dd($request->ok);
            $ok = 'Enregistrement succès';
            return view('espace.annonces.create', compact('parcours', 'niveaux', 'types', 'ok'));
        }

        return view('espace.annonces.create', compact('parcours', 'niveaux', 'types'));
    }

    public function store(AnnonceRequest $request)
    {
        # dd($request->all());

        $inputs = $this->getInputs($request);

        $annonce = Annonce::create($inputs);

        $annonce->niveau()->attach($request->niveau_id);
        $annonce->parcours()->attach($request->parcours_id);

        return redirect()->route('espace.annonces.galeries.view', ['annonce' => $annonce]);
    }

    public function galeriesView(Annonce $annonce)
    {
        return view('espace.annonces.galerie', compact('annonce'));
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

        if ($annonce->galerie) {
            if (count($annonce->galerie) > 0) {
                $data = $data->merge($annonce->galerie);
            }
        }

        $name = $request->file('file')->getClientOriginalName();

        if (in_array($request->file('file')->extension(), $extensions_images)) {
            $img   = Image::make($request->file('file')->path());

            $img->resize(1000, 800)->encode()->save(public_path('/storage/images/') . $name);
            $img->resize(400, 400)->encode()->save(public_path('/storage/images/thumbs/') . $name);
        } else {
            $request->file('file')->storeAs('public\fichiers', $name);
        }

        # array_push($data, $name);
        $data->push($name);

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

        if (in_array($extension, $extensions_images)) {
            File::delete([
                public_path('/storage/images/') . $filename,
                public_path('/storage/images/thumbs/') . $filename,
            ]);
        } else {
            File::delete([
                public_path('/storage/fichiers/') . $filename,
            ]);
        }

        if ($annonce->galerie) {
            if (count($annonce->galerie) > 0) {
                foreach ($annonce->galerie as $piece) {
                    if ($piece != $filename) {
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
        $inputs = $request->except(['image']);

        if ($request->image) {
            $inputs['image'] = $this->saveImages($request);
        }

        # dd($inputs);

        return $inputs;
    }

    protected function saveImages($request)
    {

        $image = $request->file('image');
        $name  = time() . '.' . $image->extension();
        $img   = Image::make($image->path());

        # $img->resize(width, height);

        $img->resize(1000, 800)->encode()->save(public_path('/storage/images/') . $name);
        $img->resize(400, 400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

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
