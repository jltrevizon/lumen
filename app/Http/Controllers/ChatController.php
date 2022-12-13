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

    /**
     * @OA\Post(
     *     path="/api/chat",
     *     tags={"chats"},
     *     summary="Create message",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createMessage",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Chat"),
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="",
     *         value=@OA\JsonContent(
     *              @OA\Property(
     *                         property="message",
     *                         type="string",
     *                     )
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Create message",
     *         required=true,
     *         value=@OA\JsonContent(
     *                     @OA\Property(
     *                         property="campa_id",
     *                         type="integer",
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                     )
     *          ),
     *     )
     * )
     */

    public function createMessage(Request $request){
        return $this->chatRepository->createMessage($request);
    }

    /**
     * @OA\Post(
     *     path="/api/chat-app",
     *     tags={"chats"},
     *     summary="Create message app",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createMessageApp",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Chat"),
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="",
     *         value=@OA\JsonContent(
     *              @OA\Property(
     *                         property="message",
     *                         type="string",
     *                     )
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Create message app",
     *         required=true,
     *         value=@OA\JsonContent(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                     ),
     *                     @OA\Property(
     *                         property="campa_id",
     *                         type="integer",
     *                     )
     *          ),
     *     )
     * )
     */

    public function createMessageApp(Request $request){
        return $this->chatRepository->createMessageApp($request);
    }

    /**
     * @OA\Post(
     *     path="/api/get-message",
     *     tags={"chats"},
     *     summary="Get message",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="getMessage",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Chat"),
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="",
     *         value=@OA\JsonContent(
     *              @OA\Property(
     *                         property="message",
     *                         type="string",
     *                     )
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Create message app",
     *         required=true,
     *         value=@OA\JsonContent(
     *                     @OA\Property(
     *                         property="campa_id",
     *                         type="integer",
     *                     )
     *          ),
     *     )
     * )
     */

    public function getMessage(Request $request){
        return $this->chatRepository->getMessage($request);
    }

    /**
    * @OA\Get(
    *     path="/api/get-message-app",
    *     tags={"chats"},
    *     summary="Get message app",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *       name="id",
    *       in="query",
    *       description="id",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Chat"),
    *     ),
    *     @OA\Response(
    *         response="409",
    *         description="",
    *         value=@OA\JsonContent(
    *              @OA\Property(
    *                         property="message",
    *                         type="string",
    *                     )
    *         )
    *     )
    * )
    */

    public function getMessageApp(Request $request){
        return $this->chatRepository->getMessageApp($request);
    }

    /**
     * @OA\Post(
     *     path="/api/read-messages",
     *     tags={"chats"},
     *     summary="Read messages",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="readMessages",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         value=@OA\JsonContent(
     *              @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="OK"
     *                     )
     *         )
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="",
     *         value=@OA\JsonContent(
     *              @OA\Property(
     *                         property="message",
     *                         type="string",
     *                     )
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Create message app",
     *         required=true,
     *         value=@OA\JsonContent(
     *                     @OA\Property(
     *                         property="messages",
     *                         type="array",
     *                         @OA\Items(ref="#/components/schemas/Message"),
     *                     )
     *          ),
     *     )
     * )
     */

    public function readMessages(Request $request){
        return $this->chatRepository->readMessages($request);
    }
}
