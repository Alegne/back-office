<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\EnseignantRequest;
use App\Http\Resources\API\EnseignantResource;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class EnseignantController extends Controller
{
    public function info(Enseignant $enseignant)
    {
        return new EnseignantResource($enseignant);
    }

    public function update(Request $request, Enseignant $enseignant)
    {

        # dd($request->all(), $request->photo);

        $validator = Validator::make(
            $request->all(), [
            'identifiant'   => 'required|unique:cactus_enseignants',
            'nom'           => 'required',
            'prenom'        => 'required',
            'email'         => 'required|unique:cactus_enseignants',
            'telephone'     => 'required|numeric',
            'adresse'       => 'required',
            'photo'         => ''
        ]);

        # dd($validator->fails());

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => 'Error',
                'errors' => $validator->errors(),
            ], 422);
        }


        $inputs = $this->getInputs($request);

        if($request->has('photo') && $request->photo) {

            $this->deleteImages($enseignant);
        }

        $enseignant->update($inputs);

        return new EnseignantResource($enseignant);

    }

    # DropZoneJS
    public function changePhoto(Request $request, Enseignant $enseignant)
    {
        if($request->has('file') && $request->file) {

            $this->deleteImages($enseignant);
        }

        $enseignant->update([
            'photo' => $this->saveImages($request)
        ]);

        return new EnseignantResource($enseignant);
    }


    ### Manage upload image

    protected function getInputs($request)
    {
        $mot_de_passe = Hash::make($request->mot_de_passe);

        $inputs = $request->except(['photo']);

        if($request->photo) {
            $inputs['photo'] = $this->saveImages($request);
        }

        $inputs['mot_de_passe'] = $mot_de_passe;

        return $inputs;
    }

    protected function saveImages($request)
    {
        if ($request->file('photo'))
        {
            $image = $request->file('photo');
        } elseif ($request->file('file'))
        {
            $image = $request->file('file');
        }

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
