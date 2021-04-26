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
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        $emploiDuTemps->parcours()->attach($request->parcours_id);

        # return back()->with('ok', 'The post has been successfully created');

        # dd($request->parcours_id, json_encode($request->parcours_id));

        # dd($emploiDuTemps->date_debut, gettype($emploiDuTemps->date_debut));

        # redirection
        return redirect()->route('emploi-du-temps.calendar.show', [
            'id'        => $emploiDuTemps->id,
            'niveau'    => $emploiDuTemps->niveau_id,
            #'parcours' => json_encode($request->parcours_id)
            'parcours'  => implode('-', $request->parcours_id),
            'start'     => $emploiDuTemps->date_debut, # formatDateChiffre(
            'end'       => $emploiDuTemps->date_fin
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
            'id'         => $emploiDuTemps->id,
            'niveau'     => $emploiDuTemps->niveau_id,
            # 'parcours' => $request->parcours_id,
            'parcours'   => implode('-', $request->parcours_id),
            'start'      => $emploiDuTemps->date_debut,
            'end'        => $emploiDuTemps->date_fin
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
     * @param $parcours
     * @param $start
     * @param $end
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showCalendar(Request $request, $id, $niveau, $parcours, $start = '', $end = '')
    {
        # dd(json_decode($parcours)); json_decode($parcours)

        #dd(explode('-', $parcours));

        $matiereParcours = MatiereParcours::whereIn('parcours_id', explode('-', $parcours))
            ->select('matiere_id');

        $matieres = Matiere::whereIn('id', $matiereParcours)
            ->where('niveau_id', $niveau)
            # ->whereIn('parcours_id', json_decode($parcours))
            ->get();

        # dd($matieres);

        $emploiDuTemps = EmploiTemps::find($id);

        if ($request->ajax() or $request->ajax == 1) {

            $from = date($start);
            $to = date($end);

            if ($start and $end) {
                $items = EmploiTempsItem::where('emploi_du_temps_id', $id)
                    # ->where('heure_debut', '>=', $from)
                    # ->where('heure_fin', '<=', $to)
                    # ->whereDate('start', '>=', $request->start)
                    # ->whereDate('end',   '<=', $request->end)
                    ->get();
            } else {
                $items = EmploiTempsItem::where('emploi_du_temps_id', $id)
                    # ->where('heure_debut', '>=', $from)
                    # ->where('heure_fin', '<=', $to)
                    # ->whereDate('start', '>=', $request->start)
                    # ->whereDate('end',   '<=', $request->end)
                    ->get();
            }

            # dd($items, $from, $to, gettype($from));
            # dd($items->toSql(), $id, $start, $end);

            $tab = [];

            foreach ($items as $item) {
                $enseignant = Enseignant::find($item->matiere->enseignant_id);
                $matiere = Matiere::find($item->matiere_id);

                $calendar = new Calendar(
                    $item->id,
                    $item->matiere->libelle . ' : ' . $enseignant->nom . ' ' . $enseignant->prenom,
                    $item->heure_debut,
                    $item->heure_fin,
                    $item->matiere->couleur,
                    $item->matiere_id,
                    json_encode($matiere->parcours->pluck('tag'))
                );

                array_push($tab, $calendar);
            }

            # dd($tab);
            return response()->json($tab);
        }

        return view('back.emploiDuTemps.calendar', compact(
            'id',
            'matieres',
            'emploiDuTemps',
            'niveau',
            'start',
            'end'
        ));
    }

    public function calendar(Request $request)
    {
        # dd($request->ajax(), $request->type);
        if ($request->ajax()) {
            if ($request->type == 'add' || $request->type == 'add-drop') {
                $item = EmploiTempsItem::create([
                    'heure_debut'         =>    $request->heure_debut,
                    'heure_fin'             =>    $request->heure_fin,
                    'emploi_du_temps_id' =>    $request->emploi_du_temps_id,
                    'matiere_id'         =>    $request->matiere_id,
                    'specification'         =>    $request->type == 'add' ?
                        json_encode($request->specification) :
                        $request->specification
                ]);

                return response()->json($item);
            }

            if ($request->type == 'update' || $request->type == 'update-resize') {
                $item = EmploiTempsItem::find($request->id)->update([
                    'heure_debut'         =>    $request->heure_debut,
                    'heure_fin'             =>    $request->heure_fin,
                    'emploi_du_temps_id' =>    $request->emploi_du_temps_id,
                    'matiere_id'         =>    $request->matiere_id,
                    'specification'         =>    $request->type == 'update' ?
                        json_encode($request->specification) :
                        $request->specification
                ]);

                return response()->json($item);
            }

            if ($request->type == 'delete') {
                $item = EmploiTempsItem::find($request->id)->delete();

                return response()->json($item);
            }
        }
    }

    public function seed()
    {
        $emploiTemps = EmploiTemps::all();

        # dd($emploiTemps);
        foreach ($emploiTemps as $e) {
            # start: '2019-08-12T10:30:00'
            $start = $e->date_debut;
            # $now = Carbon::now();

            for ($i = 0; $i < 5; $i++) {
                # dd($i);
                # $user->premiumDate->addDays(5);
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $start);
                $heure_debut = $date->addDays($i);


                # $date_1 = Carbon::createFromFormat('Y-m-d H:i:s', $start);

                $string = $date->format('Y-m-d');

                $heure_fin = $heure_debut
                    # ->addDays($i)
                    ->addHours(2)
                    # ->addHour()
                ;

                #try {
                # dd($start, $heure_debut, $heure_fin, date('Y-m-d H:i:s'), gettype(date('Y-m-d H:i:s')));
                # dd($start, $heure_debut, $heure_fin, $string);

                $item = EmploiTempsItem::create([
                    'heure_debut'        => $heure_debut, # date('Y-m-d H:i:s'),#
                    'heure_fin'          => $heure_fin, # date('Y-m-d H:i:s'),#
                    'emploi_du_temps_id' => $e->id,
                    'matiere_id'         => random_int(1, 10),
                    'specification'      =>  'SP'
                ]);

                # dd($item);
                # } catch (\Exception $e) {
                #     echo "Exception";
                # }
            }
        }

        return response()->json(['title' => 'YES']);
    }
}
