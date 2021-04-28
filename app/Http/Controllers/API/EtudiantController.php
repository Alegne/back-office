<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\EtudiantResource;
use App\Http\Resources\API\EtuditantStatusResource;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class EtudiantController extends Controller
{
    use FilterTrait;

    public function info(Etudiant $etudiant)
    {
        return new EtudiantResource($etudiant);
    }

    public function all()
    {
        # return EtudiantResource::collection(Etudiant::all());
        return EtudiantResource::collection(Etudiant::paginate(2));
    }

    public function update(Request $request, Etudiant $etudiant)
    {

        # dd($request->photo);
        # 422
        try {
            $request->validate([
                'email'          => 'required|unique:cactus_etudiants|email',
                'nom'            => 'required',
                'prenom'         => 'required',
                'password'       => 'required',
                'cin'            => 'required|numeric',
                'date_naissance' => 'required',
                'lieu_naissance' => 'required',
                'adresse'        => 'required',
                'photo'          => 'file|mimes:jpeg,jpg,png,gif|max:10000',
            ]);

            $inputs = $this->getInputs($request);

            if($request->has('photo') && $request->photo) {

                $this->deleteImages($etudiant);
            }

            $etudiant->update($inputs);

            # dd($etudiant, $etudiant->id, $request->photo);

            return new EtudiantResource($etudiant);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'msg'    => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }

    }

    # DropZoneJS
    public function changePhoto(Request $request, Etudiant $etudiant)
    {
        if($request->has('file') && $request->file) {

            $this->deleteImages($etudiant);
        }

        $etudiant->update([
            'photo' => $this->saveImages($request)
        ]);

        return new EtudiantResource($etudiant);
    }

    public function filter(Request $request)
    {
        # dd($request->all());

        $query = Etudiant::query();

        $query = $this->contraintes($request, $query);

        # $etudiants = Etudiant::withFilters(
        #     request()->input('status', []),
        #     request()->input('parcours', [])
        # )
        #     ->get()
        # ;

        # dd($query->toSql());

        $etudiants = $query->get();

        # dd($etudiants);

        return EtudiantResource::collection($etudiants);
    }

    public function status(Request $request)
    {
        # $query = Etudiant::count()->where('parcours_id', 1);

        # dd($query);

        $query = Etudiant::query();

        $query = $this->contraintes($request, $query);

        # dd($query->toSql());

        $etudiants = $query
            # ->count()->groupBy('status')
            ->groupBy('status')->select('status', DB::raw('count(*) as etudiants_count'))->get()
            ;

        # dd($etudiants);

        # return new EtuditantStatusResource($etudiants);
        return EtuditantStatusResource::collection($etudiants);
    }

    ### Manage upload image

    protected function getInputs($request)
    {
        $password = Hash::make($request->password);

        $inputs = $request->except(['photo', 'password']);

        # $inputs['active'] = $request->has('active');

        if($request->photo) {
            $inputs['photo'] = $this->saveImages($request);
        }

        $inputs['password'] = $password;

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

    protected function deleteImages($etudiant)
    {
        File::delete([
            public_path('/storage/images/') . $etudiant->photo,
            public_path('/storage/images/thumbs/') . $etudiant->photo,
        ]);
    }
}
