<?php

namespace App\Http\Controllers\Back;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\UserRequest;
use App\Models\User;
use App\Notifications\NouveauCompte;
use App\Rules\GenericUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
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
        $user = null;

        $roles = [
            'redacteur'   => 'Redacteur',
            'admin'       => 'Administrateur',
            'annonceur'   => 'Annonceur',
            'pedagogique' => 'Pedagogique'
        ];

        return view('back.user.form', compact('user', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request->merge(['password' => Hash::make('password')]);

        $inputs = $this->getInputs($request);

        $user = User::create($inputs);

        ### Notification
        $user->notify(new NouveauCompte($user->email, true, null, $user->identifiant, null));

        return back()->with('ok', 'L\'utilisateur a été ajouté avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $desactiver = $request->desactiver == 1 ? true : false;
        return view('back.user.show', compact('user',  'desactiver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        $roles = [
            'redacteur'   => 'Redacteur',
            'admin'       => 'Administrateur',
            'annonceur'   => 'Annonceur',
            'pedagogique' => 'Pedagogique'
        ];

        return view('back.user.form', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'identifiant'        => ['required', new GenericUpdate('cactus_users', 'identifiant',
                                                    $request->identifiant, $user->id)],
            'email'        => ['required', 'email', new GenericUpdate('cactus_users', 'email',
                                                    $request->email, $user->id)],
            'role'         => 'required',
            'photo'          => 'mimes:jpeg,jpg,png,gif|max:10000'
        ]);

        $inputs = $this->getInputs($request);

        if ($request->has('photo') && $request->file('photo')) {
            $this->deleteImages($user);
        }

        $user->update($inputs);

        return back()->with('ok', 'L\'utilisateur a été mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {

        try{
            $user->delete();
            $this->deleteImages($user);
        } catch (\Exception $e)
        {
            return response()->json([
                'ok'      => false,
                'message' => "Erreur de Suppresion, d'autres enregistrements dependent de cet utilisateur " .  $user->identifiant
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
        # dd($request->all());
        # dd($request->file('photo'));

        $inputs = $request->except(['photo']);

        # $inputs['active'] = $request->has('active');

        if ($request->has('photo')) {


            $inputs['photo'] = $this->saveImages($request);
        }

        # dd($inputs);

        return $inputs;
    }

    protected function saveImages($request)
    {

        $image = $request->file('photo');
        $name  = time() . '.' . $image->extension();
        $img   = Image::make($image->path());

        # $img->resize(width, height);

        $img->resize(1000,800)->encode()->save(public_path('/storage/images/') . $name);
        $img->resize(400,400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        return $name;
    }

    protected function deleteImages($user)
    {
        File::delete([
            public_path('/storage/images/') . $user->image,
            public_path('/storage/images/thumbs/') . $user->image,
        ]);
    }
}
