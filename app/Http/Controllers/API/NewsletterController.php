<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\NewsletterRequest;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{

    public function post(Request $request)
    {
        try {
            $request->validate([
                'email'     => 'required|unique:cactus_newsletters',
                //
            ]);

            $newsLetter = Newsletter::create($request->all());

            return response()->json([
                'message' => 'sucess',
                'data'    => $newsLetter,
            ]);
        }catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'msg'    => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }
}
