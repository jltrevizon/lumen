<?php

namespace App\Http\Controllers;

use App\Repositories\ChatRepository;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function createMessage(Request $request){
        return $this->chatRepository->createMessage($request);
    }

    public function createMessageApp(Request $request){
        return $this->chatRepository->createMessageApp($request);
    }

    public function getMessage(Request $request){
        return $this->chatRepository->getMessage($request);
    }

    public function getMessageApp(Request $request){
        return $this->chatRepository->getMessageApp($request);
    }

    public function readMessages(Request $request){
        return $this->chatRepository->readMessages($request);
    }
}
