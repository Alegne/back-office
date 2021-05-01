<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\MessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class MessageController extends Controller
{
    public function post(Request $request)
    {
        try {
            $request->validate([
                'email'     => 'required',
                'objet'     => 'required',
                'message'   => 'required',
                # 'telephone' => 'required'
            ]);

            $request->merge(['telephone' => 0342562533]);

            $message_create = Message::create($request->all());

            Mail::to(config('app.mail_admin'))
                ->send(new \App\Mail\Message($request->message, $request->objet, $request->email));

            return response()->json([
                'message' => 'sucess',
                'data'    => $message_create,
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
