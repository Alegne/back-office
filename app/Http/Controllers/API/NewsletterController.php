<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\NewsletterRequest;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{

    public function post(NewsletterRequest $request)
    {

        $newsLetter = Newsletter::create($request->all());

        return response()->json([
            'message' => 'sucess',
            'data'    => $newsLetter,
        ]);
    }
}
