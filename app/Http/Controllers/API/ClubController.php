<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ClubResource;
use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function all()
    {
        return ClubResource::collection(Club::all());
    }

    public function get(Club $club)
    {
        return new ClubResource($club);
    }
}
