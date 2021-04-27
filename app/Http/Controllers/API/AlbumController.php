<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\AlbumResource;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function all()
    {
        return AlbumResource::collection(Album::all());
    }

    public function paginate()
    {
        return AlbumResource::collection(Album::paginate(10));
    }

    public function get(Album $album)
    {
        return new AlbumResource($album);
    }
}
