<?php

namespace App\Http\Controllers\Espace;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('espace', ['except' => [
            'index'
        ]]);
    }

    public function index(Request $request)
    {
        # dd('die');

        $data = null;
        $type = null;

        if ($request->has('type') && $request->type) {
            $type = $request->type;

            if ($request->type == 'etudiant') {
                if ($request->has('id') && $request->id) {
                    $data = Etudiant::find($request->id);

                    # dd($data);

                    if ($data) {
                        $type = 'etudiant';

                        #### Delete Session | Coockie
                        # Cookie::expire('espace_utlisateur');
                        Cookie::forget('espace_utlisateur');
                        $request->session()->forget('espace_utlisateur');


                        session(['espace_utlisateur' => json_encode($data)]);
                        # $cookie = cookie('name', 'value', $minutes);

                        # Cookie::queue('espace_utlisateur', json_encode($data), $minutes);
                        Cookie::queue(cookie()->forever('espace_utlisateur', json_encode($data)));

                        return view('espace.index', compact('data', 'type'));
                    }
                }
            } elseif ($request->type == 'enseignant') {
                if ($request->has('id') && $request->id) {
                    $data = Enseignant::find($request->id);

                    if ($data) {
                        $type = 'enseignant';

                        #### Delete Session | Coockie
                        # Cookie::expire('espace_utlisateur');
                        Cookie::forget('espace_utlisateur');
                        $request->session()->forget('espace_utlisateur');

                        session(['espace_utlisateur' => json_encode($data)]);
                        Cookie::queue(cookie()->forever('espace_utlisateur', json_encode($data)));

                        return view('espace.index', compact('data', 'type'));
                    }
                }
            }
        }

        $data = session('espace_utlisateur');

        if ($data) {
            $data = json_decode($data);
            # dd(isset($data->identifiant));

            $data = isset($data->identifiant) ? Enseignant::find($data->id) : Etudiant::find($data->id);

            # dd($data, $data->id);

            return view('espace.index', compact('data', 'type'));
        }

        $data = $request->cookie('espace_utlisateur');

        if ($data) {
            $data = json_decode($data);

            $data = isset($data->identifiant) ? Enseignant::find($data->id) : Etudiant::find($data->id);

            return view('espace.index', compact('data', 'type'));
        }

        # Get Session
        # dd(session('espace_utlisateur'), $request->token, $request->id, $request->type);

        return redirect(config('app.front_office'));
    }

    public function logout(Request $request)
    {
        #### Delete Session | Coockie
        # Cookie::expire('espace_utlisateur');
        Cookie::forget('espace_utlisateur');
        $request->session()->forget('espace_utlisateur');

        # dd(config('app.front_office'));

        return redirect(config('app.front_office'));
    }
}
