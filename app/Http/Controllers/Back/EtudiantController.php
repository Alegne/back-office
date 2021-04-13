<?php

namespace App\Http\Controllers\Back;

use App\DataTables\EtudiantDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\EtudiantRequest;
use App\Models\AnneeUniversitaireLibelle;
use App\Models\Etudiant;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
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
     * @param EtudiantRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EtudiantRequest $request)
    {
        # dd($request);

        $request->merge(['password' => Hash::make($request->password)]);

        # dd($request->all());

        $etudiant = Etudiant::create($request->all());

        $etudiant->niveau()->attach($request->niveau_id);

        DB::table('cactus_annee_universitaires')
            ->where('etudiant_id', $etudiant->id)
            ->where('niveau_id', $request->niveau_id)
            ->update([
                'annee_id' => $request->annee_id
            ]);
        # $etudiant->niveau()->sync();

        return back()->with('ok', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function show(Etudiant $etudiant)
    {
        //
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
        # dd($request);

        $request->merge(['password' => Hash::make($request->password)]);

        $etudiant->update($request->all());

        $etudiant->niveau()->sync($request->niveau_id);

        # dd($request->annee_id, $request->niveau_id,
        #     count($request->niveau_id),
        #     $request->niveau_id[0], gettype($request->niveau_id[0]),
        #     gettype((int) $request->niveau_id[0]));

        for ($i = 0; $i < count($request->niveau_id); $i++) {
            DB::table('cactus_annee_universitaires')
                ->where('etudiant_id', $etudiant->id)
                ->where('niveau_id', (int) $request->niveau_id[$i])
                ->update([
                    'annee_id' => (int)$request->annee_id[$i]
                ]);
        }

        # foreach ($request->annee_id as $annee)
        # {
        #     DB::table('cactus_annee_universitaires')
        #         ->where('etudiant_id', $etudiant->id)
        #         ->where('niveau_id', $request->niveau_id)
        #         ->update([
        #             'annee_id' => $annee
        #         ]);
        # }

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
        $etudiant->delete();

        return response()->json();
    }
}
