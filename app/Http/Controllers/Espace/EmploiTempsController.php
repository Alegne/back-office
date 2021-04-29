<?php

namespace App\Http\Controllers\Espace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmploiTempsController extends Controller
{
    public function index(Request $request)
    {
        return view('espace.emploi_temps.index');
    }
}
