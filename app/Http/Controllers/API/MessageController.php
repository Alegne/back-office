<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\MessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function post(MessageRequest $request)
    {

        $message = Message::create($request->all());

        return response()->json([
            'message' => 'sucess',
            'data'    => $message,
        ]);
    }
}
