<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function getToken()
    {
        # 'api_token' => Str::random(60),

        return response()->json([
            'token' => csrf_token()
        ]);
    }
}
