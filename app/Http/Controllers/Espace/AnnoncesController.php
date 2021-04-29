<?php

namespace App\Http\Controllers\Espace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnoncesController extends Controller
{
    public function index(Request $request)
    {
        return view('espace.annonces.index');
    }
}
