<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\FormationResource;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function all()
    {

        return FormationResource::collection(Formation::all());
    }

    public function get(Formation $formation)
    {
        # return new FormationResource(Formation::findOrFail($id));
        return new FormationResource($formation);
    }
}
