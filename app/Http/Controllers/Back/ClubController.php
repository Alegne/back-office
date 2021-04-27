<?php

namespace App\Http\Controllers\Back;

use App\DataTables\ClubDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\ClubRequest;
use App\Http\Requests\Back\StaffRequest;
use App\Models\Club;
use App\Models\Etudiant;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ClubDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ClubDataTable $dataTable)
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
        $club = null;

        return view('back.club.form', compact('club'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClubRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClubRequest $request)
    {
        $inputs = $this->getInputs($request);

        Club::create($inputs);

        return back()->with('ok', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club)
    {
        return view('back.club.form', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClubRequest $request
     * @param  \App\Models\Club $club
     * @return \Illuminate\Http\Response
     */
    public function update(ClubRequest $request, Club $club)
    {
        $inputs = $this->getInputs($request);

        if($request->has('image') && $request->image) {
            $this->deleteImages($club);
        }

        $club->update($inputs);

        return back()->with('ok', 'The post has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Club $club
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Club $club)
    {
        # supprimer staff

        $club->delete();
        $this->deleteImages($club);

        return response()->json();
    }

    /**
     * Add staff
     *
     * @param Request $request
     * @param Club $club
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addStaffView(Request $request, Club $club)
    {
        $etudiants_id = collect();
        $leader = false;

        if (count($club->staffs))
        {
            foreach ($club->staffs as $staff)
            {
                $etudiants_id->push($staff->etudiant_id);

                if ($staff->type == 'leader')
                {
                    $leader = true;
                }
            }

        }

        if (count($etudiants_id))
        {
            # NumeroName
            # $etudiants = Etudiant::whereNotIn('id', $etudiants_id->all())->get()->pluck('numero', 'id');
            $etudiants = Etudiant::whereNotIn('id', $etudiants_id->all())->get()->pluck('numero_name', 'id');
        } else {
            # $etudiants = Etudiant::all()->pluck('numero', 'id');
            $etudiants = Etudiant::all()->pluck('numero_name', 'id');
        }

        $types = !$leader ? [
            'leader' => 'Leader',
            'membre' => 'Membre'
        ] : ['membre' => 'Membre'];

        return view('back.club.add_staff', compact('club', 'etudiants', 'types'));
    }

    /**
     * Requete Ajax
     *
     * @param StaffRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addStaffStore(StaffRequest $request)
    {
        Staff::insert([
            'club_id'     => $request->club_id,
            'etudiant_id' => $request->etudiant_id,
            'type'        => $request->type
        ]);

        if (request()->ajax())
        {
            return response()->json();
        }
        return back()->with('ok', 'The post has been successfully updated');
    }


    ### Manage upload image

    protected function getInputs($request)
    {
        $inputs = $request->except(['image']);

        # dd($request->all());

        # $inputs['active'] = $request->has('active');

        if($request->file('image')) {
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

        $img->widen(800)->encode()->save(public_path('/storage/images/') . $name);
        $img->widen(400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        return $name;
    }

    protected function deleteImages($club)
    {
        File::delete([
            public_path('/storage/images/') . $club->image,
            public_path('/storage/images/thumbs/') . $club->image,
        ]);
    }

    public function deleteStaff(Staff $staff)
    {
        # dd($staff);

        $staff->delete();

        return response()->json(['message' => 'success']);
    }

}
