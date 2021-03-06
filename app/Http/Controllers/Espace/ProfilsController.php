<?php

namespace App\Http\Controllers\Espace;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Niveau;
use App\Models\Parcours;
use App\Rules\GenericUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProfilsController extends Controller
{

    public function index(Request $request)
    {
        $data = json_decode($request->cookie('espace_utlisateur'));

        $type = isset($data->identifiant) ? 'enseignant' : 'etudiant';

        if ($type == 'etudiant')
            $data = Etudiant::find($data->id);
        else
            $data = Enseignant::find($data->id);

        # dd($data, $data->niveau[0]->tag);

        return view('espace.profils.index', compact('data', 'type'));
    }

    public function update(Request $request, $id, $type)
    {
        $enseignant = null;
        $etudiant   = null;

        if ($type == 'etudiant')
        {
            $request->validate([
                'email'          => ['required', 'email', new GenericUpdate('cactus_etudiants', 'email',
                                                                $request->email, $id) ],
                'nom'            => 'required',
                'prenom'         => 'required',
                'password'       => 'required',
                'cin'            => ['required', 'numeric', new GenericUpdate('cactus_etudiants', 'cin',
                                                                $request->cin, $id)],
                'date_naissance' => 'required',
                'lieu_naissance' => 'required',
                'adresse'        => 'required',
                'photo'          => 'file|mimes:jpeg,jpg,png,gif|max:10000',
            ]);
        } elseif ($type == 'enseignant')
        {
            $request->validate([
                /*'identifiant'   => ['required', new GenericUpdate('cactus_enseignants', 'identifiant',
                                                                $request->identifiant, $id)],*/
                'nom'           => 'required',
                'prenom'        => 'required',
                'email'         => ['required', 'email', new GenericUpdate('cactus_enseignants', 'email',
                                                                $request->email, $id)],
                'telephone'     => 'required|numeric',
                'adresse'       => 'required',
                'photo'         => 'file|mimes:jpeg,jpg,png,gif|max:10000'
            ]);

            # Identifiant
            $nom = Str::lower($request->nom);
            $prenom = Str::lower($request->prenom);
            $identiiant = Str::slug($nom . '-' . $prenom);
            $request->merge(['identifiant' => $identiiant]);
        }

        # dd($validator->fails());

        # dd($request->all());

        if ($type == 'etudiant')
            $etudiant = Etudiant::find($id);
        elseif ($type == 'enseignant')
            $enseignant = Enseignant::find($id);

        if ($etudiant)
        {
            $request->merge(['password' => Hash::make($request->password)]);

            $inputs = $this->getInputs($request);

            if ($request->has('photo') && $request->photo) {

                # dd('condition');
                $this->deleteImages($etudiant);
            }

            $etudiant->update($inputs);
        } elseif ($enseignant)
        {
            $request->merge(['mot_de_passe' => Hash::make($request->mot_de_passe)]);

            $inputs = $this->getInputs($request);

            if ($request->has('photo') && $request->photo) {

                # dd('condition');
                $this->deleteImages($enseignant);
            }

            $enseignant->update($inputs);
        } else
        {
            return back()->with('ok', 'Mise ?? jour a ??t?? un succ??s');
        }


        return back()->with('ok', 'Mise ?? jour a ??t?? un succ??s');
    }

    ### Manage upload image

    protected function getInputs($request)
    {
        $inputs = $request->except(['photo']);

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
        $img->resize(1000,400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        return $name;
    }

    protected function deleteImages($etudiant)
    {
        File::delete([
            public_path('/storage/images/') . $etudiant->photo,
            public_path('/storage/images/thumbs/') . $etudiant->photo,
        ]);
    }
}
