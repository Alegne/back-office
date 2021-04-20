<?php

namespace App\Http\Controllers\Back;

use App\DataTables\EmploiDuTempsDataTable;
use App\Http\Controllers\Controller;
use App\Models\AnneeUniversitaireLibelle;
use App\Models\Calendar;
use App\Models\EmploiTemps;
use App\Models\EmploiTempsItem;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\MatiereParcours;
use App\Models\Niveau;
use App\Models\Parcours;
use http\Env\Response;
use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param EmploiDuTempsDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(EmploiDuTempsDataTable $dataTable)
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
        $emploiDuTemps = null;

        $parcours = Parcours::all()->pluck('tag', 'id');
        $niveaux = Niveau::all()->pluck('tag', 'id');
        $annees = AnneeUniversitaireLibelle::all()->pluck('libelle', 'id');

        return view('back.emploiDuTemps.form', compact('emploiDuTemps', 'parcours', 'niveaux', 'annees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $emploiDuTemps = EmploiTemps::create($request->all());

        $emploiDuTemps->parcours()->sync($request->parcours_id);

        # return back()->with('ok', 'The post has been successfully created');

        # dd($request->parcours_id, json_encode($request->parcours_id));

        # redirection
        return redirect()->route('emploi-du-temps.calendar.show', [
            'id'     => $emploiDuTemps->id,
            'niveau' => $emploiDuTemps->niveau_id,
            'parcours' => json_encode($request->parcours_id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param EmploiTemps $emploiDuTemps
     * @return void
     */
    public function show(EmploiTemps $emploiDuTemps)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EmploiTemps $emploiDuTemps
     * @return \Illuminate\Http\Response
     */
    public function edit(EmploiTemps $emploiDuTemps)
    {
        $parcours = Parcours::all()->pluck('tag', 'id');
        $niveaux = Niveau::all()->pluck('tag', 'id');
        $annees = AnneeUniversitaireLibelle::all()->pluck('libelle', 'id');

        # $emploiDuTemps = EmploiTemps::find($id);
        return view('back.emploiDuTemps.form', compact('emploiDuTemps', 'parcours', 'niveaux', 'annees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param EmploiTemps $emploiDuTemps
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmploiTemps $emploiDuTemps)
    {
        # $emploiDuTemps = EmploiTemps::find($id);
        $emploiDuTemps->update($request->all());

        $emploiDuTemps->parcours()->sync($request->parcours_id);

        # return back()->with('ok', 'The post has been successfully updated');

        # redirection
        return redirect()->route('emploi-du-temps.calendar.show', [
            'id'       => $emploiDuTemps->id,
            'niveau'   => $emploiDuTemps->niveau_id,
            'parcours' => $request->parcours_id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EmploiTemps $emploiDuTemps
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(EmploiTemps $emploiDuTemps)
    {
        # $emploiDuTemps = EmploiTemps::find($id);
        $emploiDuTemps->delete();

        return response()->json();
    }

    /**
     * Show Calendar
     *
     * @param Request $request
     * @param $id
     * @param $niveau
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showCalendar(Request $request, $id, $niveau, $parcours)
    {
        # dd(json_decode($parcours));

        $matiereParcours = MatiereParcours::whereIn('parcours_id', json_decode($parcours))
                                         ->select('matiere_id');

        $matieres = Matiere::whereIn('id', $matiereParcours)
                            ->where('niveau_id', $niveau)
                            # ->whereIn('parcours_id', json_decode($parcours))
                            ->get()
        ;

        # dd($matieres);

        $emploiDuTemps = EmploiTemps::find($id);

        if ($request->ajax()){
            $items = EmploiTempsItem::where('emploi_du_temps_id', $id)->get();
            $tab = [];

            foreach ($items as $item)
            {
                $enseignant = Enseignant::find($item->matiere->enseignant_id);
                $matiere = Matiere::find($item->matiere_id);

                $calendar = new Calendar(
                    $item->id,
                    $item->matiere->libelle,
                    $item->heure_debut,
                    $item->heure_fin,
                    $item->matiere->couleur,
                    $enseignant->nom . ' ' . $enseignant->prenom,
                    json_encode($matiere->parcours->pluck('tag')));

                array_push($tab, $calendar);
            }

            return response()->json($tab);
        }

        return view('back.emploiDuTemps.calendar', compact('id', 'matieres', 'emploiDuTemps', 'niveau'));
    }
}
