<?php

namespace App\Http\Controllers\Espace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EspaceNumeriquesController extends Controller
{
    public function index(Request $request)
    {
        return view('espace.espace_numeriques.index');
    }
}
