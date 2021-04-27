<?php

namespace App\Http\Controllers\Back;

use App\DataTables\EtudiantDataTable;
use App\Http\Controllers\API\FilterTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\EtudiantRequest;
use App\Http\Resources\API\EtudiantResource;
use App\Models\AnneeUniversitaireLibelle;
use App\Models\Etudiant;
use App\Models\Formation;
use App\Models\Niveau;
use App\Models\Parcours;
use App\Notifications\NouveauCompte;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;

class EtudiantController extends Controller
{

    use FilterTrait;

    /**
     * Display a listing of the resource.
     *
     * @param EtudiantDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(EtudiantDataTable $dataTable)
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
        $etudiant = null;

        # Get an array with the values of a given key.
        $parcours = Parcours::all()->pluck('tag', 'id');
        $niveaux = Niveau::all()->pluck('tag', 'id');
        $annees = AnneeUniversitaireLibelle::all()->pluck('libelle', 'id');
        $status = ['ancien' => 'Ancien', 'actif' => 'Actif'];

        # dd($parcours, $niveaux, $annees);

        return view('back.etudiant.form', compact('etudiant', 'parcours', 'niveaux', 'annees', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        # dd($request->all(), $request->has('photo'), $request->photo);

        # $request->merge(['password' => Hash::make($request->password)]);

        # $inputs = $this->getInputs($request->all());
        $inputs = $this->getInputs($request);

        $etudiant = Etudiant::create($inputs);

        $etudiant->niveau()->attach($request->niveau_id);

        DB::table('cactus_annee_universitaires')
            ->where('etudiant_id', $etudiant->id)
            ->where('niveau_id', $request->niveau_id)
            ->update([
                'annee_id' => $request->annee_id
            ]);
        # $etudiant->niveau()->sync();

        ### Notification
        $etudiant->notify(new NouveauCompte($etudiant->email, false, $etudiant->numero, null, $etudiant->nom));

        return back()->with('ok', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  \App\Models\Etudiant $etudiant
     * @return
     */
    public function show(Request $request, Etudiant $etudiant)
    {
        if ($request->ajax())
        {
            return new EtudiantResource($etudiant);
        }

        return new EtudiantResource($etudiant);
    }

    public function modal(Request $request, $email)
    {
        $etudiant = Etudiant::where('email', $email)->first();

        if ($request->ajax())
        {
            return new EtudiantResource($etudiant);
        }

        return new EtudiantResource($etudiant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function edit(Etudiant $etudiant)
    {
        $parcours = Parcours::all()->pluck('tag', 'id');
        $niveaux = Niveau::all()->pluck('tag', 'id');
        $annees = AnneeUniversitaireLibelle::all()->pluck('libelle', 'id');
        $status = ['ancien' => 'Ancien', 'actif' => 'Actif'];

        return view('back.etudiant.form', compact('etudiant', 'parcours', 'niveaux', 'annees', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EtudiantRequest $request
     * @param  \App\Models\Etudiant $etudiant
     * @return \Illuminate\Http\Response
     */
    public function update(EtudiantRequest $request, Etudiant $etudiant)
    {
        # dd($request->all(), $request->has('photo'), $request->photo);

        $request->merge(['password' => Hash::make($request->password)]);

        $inputs = $this->getInputs($request);

        if($request->has('photo') && $request->photo) {

            # dd('condition');
            $this->deleteImages($etudiant);
        }

        $etudiant->update($inputs);

        # $etudiant->update($request->all());

        $etudiant->niveau()->sync($request->niveau_id);

        for ($i = 0; $i < count($request->niveau_id); $i++) {
            DB::table('cactus_annee_universitaires')
                ->where('etudiant_id', $etudiant->id)
                ->where('niveau_id', (int) $request->niveau_id[$i])
                ->update([
                    'annee_id' => (int)$request->annee_id[$i]
                ]);
        }

        return back()->with('ok', 'The post has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Etudiant $etudiant
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Etudiant $etudiant)
    {
        # Supprimer Annee Universitaire
        $etudiant->delete();

        $this->deleteImages($etudiant);

        return response()->json();
    }

    ### Manage upload image

    protected function getInputs($request)
    {
        $inputs = $request->except(['photo']);

        # $inputs['active'] = $request->has('active');

        if($request->photo) {
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

    public function filter()
    {
        # dd('filter');

        return view('back.etudiant.filter');
    }

    public function filterJS(Request $request)
    {
        $etudiants = null;
        $data      = null;

        if (count($request->all()) > 0)
        {
            return view('back.etudiant.new-filter', compact('etudiants'));
        }
        return view('back.etudiant.new-filter', compact('etudiants'));
    }

    public function filterJSRequest(Request $request)
    {
        $etudiants = null;
        $data      = null;


        $parcours = Parcours::all()->pluck('tag');
        $niveaux = Niveau::all()->pluck('tag');
        $annees = AnneeUniversitaireLibelle::all()->pluck('libelle');
        $status = ['ancien' => 'Ancien', 'actif' => 'Actif'];
        $formations = Formation::all()->pluck('libelle');

        if ($request->ajax())
        {
            return response()->json([
                'etudiants' =>  View::make('back.etudiant.filter._etudiants', []),
                'filter'    =>  View::make('back.etudiant.filter._filter', []),
                'pagination' => View::make('back.etudiant.filter._pagination', []),
            ]);
        }

        if (count($request->all()) > 0)
        {
            $data = $request->all();

            # $query = ;

            $query = $this->contraintes($request, Etudiant::query());

            # dd($query->toSql(), $request->all(), $query->get(), $query->paginate(10), $query->simplePaginate(15));

            # $etudiants = $query->get();
            $etudiants = $query->paginate(10);
            # $etudiants = Etudiant::paginate(10);
        }

        return view('back.etudiant.new-filter',
            compact('etudiants', 'data', 'niveaux', 'parcours', 'annees', 'formations', 'status'));
    }

}
