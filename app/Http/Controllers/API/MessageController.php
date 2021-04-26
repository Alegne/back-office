<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\MessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MessageController extends Controller
{
    public function post(Request $request)
    {
        try {
            $request->validate([
                'email'     => 'required|unique:cactus_messages',
                'objet'     => 'required',
                'message'   => 'required',
                'telephone' => 'required'
            ]);

            $message = Message::create($request->all());

            return response()->json([
                'message' => 'sucess',
                'data'    => $message,
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
