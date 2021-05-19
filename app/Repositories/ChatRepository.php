<?php

namespace App\Repositories;

use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChatRepository {

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createMessage($request){
        $user = $this->userRepository->getById(Auth::id());
        $chat = new Chat();
        $chat->sent_user_app = false;
        $chat->campa_id = $request->json()->get('campa_id');
        $chat->message = $request->json()->get('message');
        $chat->save();
        return $chat;
    }

    public function createMessageApp($request){
        $user = $this->userRepository->getById(Auth::id());
        $chat = new Chat();
        $chat->sent_user_app = true;
        $chat->campa_id = $user->campa_id;
        $chat->message = $request->json()->get('message');
        $chat->save();
        return $chat;
    }

    public function getMessage($request){
        return Chat::where('campa_id', $request->json()->get('campa_id'))
                ->get();
    }

    public function getMessageApp(){
        $user = $this->userRepository->getById(Auth::id());
        return Chat::where('campa_id', $user->campa_id)
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
