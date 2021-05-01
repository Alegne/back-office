<?php

namespace App\Http\Controllers\Espace;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class GalerieController extends Controller
{
    public function index(Request $request)
    {
        $albums = Album::latest('updated_at')->paginate(8);
        return view('espace.galeries.index', compact('albums'));
    }

    public function show(Request $request, Album $album)
    {
        return view('espace.galeries.show', compact('album'));
    }
}
