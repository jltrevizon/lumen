<?php

namespace App\Repositories;

use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatRepository {

    public function __construct()
    {

    }

    public function createMessage($request){
        $chat = new Chat();
        $chat->user_sender = Auth::id();
        $chat->user_receiver = $request->json()->get('user_receiver');
        $chat->message = $request->json()->get('message');
        $chat->save();
        return $chat;
    }

    public function getMessage($request){
        return Chat::with(['user_sender','user_receiver'])
            ->where(function ($query) {
            $query->where('user_sender', Auth::id())
                ->orWhere('user_receiver', Auth::id());
            })
            ->where(function ($query) use($request){
                $query->where('user_sender', $request->json()->get('user'))
                    ->orWhere('user_receiver', $request->json()->get('user'));
            })
            ->get();

    }

    public function readMessages($request){
        foreach($request->json()->get('messages') as $message){
            $chat = Chat::where('id', $message['id'])
                        ->first();
            $chat->read = true;
            $chat->save();
        }
        return [
            'message' => 'Ok'
        ];
    }

}
