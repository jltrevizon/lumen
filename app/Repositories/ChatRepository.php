<?php

namespace App\Repositories;

use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class ChatRepository {

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createMessage($request){
        try {
            $user = $this->userRepository->getById($request, Auth::id());
            $chat = new Chat();
            $chat->sent_user_app = false;
            $chat->campa_id = $request->input('campa_id');
            $chat->message = $request->input('message');
            $chat->save();
            return $chat;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function createMessageApp($request){
        try {
            $user = $this->userRepository->getById($request, Auth::id());
            $chat = new Chat();
            $chat->sent_user_app = true;
            $chat->campa_id = $user->campa_id;
            $chat->message = $request->input('message');
            $chat->save();
            return $chat;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getMessage($request){
        try {
            return Chat::where('campa_id', $request->input('campa_id'))
                    ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getMessageApp($request){
        try {
            $user = $this->userRepository->getById($request, Auth::id());
            return Chat::where('campa_id', $user->campa_id)
                    ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function readMessages($request){
        try {
            foreach($request->input('messages') as $message){
                $chat = Chat::where('id', $message['id'])
                            ->first();
                $chat->read = true;
                $chat->save();
            }
            return [
                'message' => 'Ok'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
