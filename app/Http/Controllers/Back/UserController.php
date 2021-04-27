<?php

namespace App\Http\Controllers\Back;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\UserRequest;
use App\Models\User;
use App\Notifications\NouveauCompte;
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['password' => Hash::make('password')]);

        $inputs = $this->getInputs($request);

        $user = User::create($inputs);

        ### Notification
        $user->notify(new NouveauCompte($user->email, true, null, $user->identifiant, null));

        return back()->with('ok', 'The user has been successfully created');
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
     * @param UserRequest $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $inputs = $this->getInputs($request);

        if($request->has('photo') && $request->file('photo')) {
            $this->deleteImages($user);
        }

        $user->update($inputs);

        return back()->with('ok', 'The user has been successfully updated');
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
        $user->delete();
        $this->deleteImages($user);

        return response()->json();
    }


    ### Manage upload image

    protected function getInputs($request)
    {
        # dd($request->all());
        # dd($request->file('photo'));

        $inputs = $request->except(['photo']);

        # $inputs['active'] = $request->has('active');

        if($request->has('photo')) {

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

        $img->widen(800)->encode()->save(public_path('/storage/images/') . $name);
        $img->widen(400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

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
