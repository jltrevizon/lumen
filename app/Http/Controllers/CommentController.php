<?php

namespace App\Http\Controllers;

use App\Models\CampaUser;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentNotification;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/comments",
    *     tags={"comments"},
    *     summary="Get all comments",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *       name="with[]",
    *       in="query",
    *       description="A list of relatonship",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={"relationship1","relationship2"},
    *           @OA\Items(type="string")
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="per_page",
    *       in="query",
    *       description="Items per page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=5,
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="page",
    *       in="query",
    *       description="Page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=1,
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/CommentPaginate")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function index(Request $request){
        return $this->getDataResponse($this->commentRepository->index($request), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/comments",
     *     tags={"comments"},
     *     summary="Create comment",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createComment",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Comment"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create comment object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Comment"),
     *     )
     * )
     */

    public function store(Request $request){
        $data = $this->commentRepository->store($request);
        $ids = CampaUser::where('campa_id', $data->vehicle->campa_id)
            ->get()
            ->pluck('user_id');
        $send_to = User::whereIn('id', $ids)->get();
        $comment = Comment::with('damage')->find($data['id']);
        foreach ($send_to as $key => $value) {
            Notification::send($value, new CommentNotification([
                'data' => $comment,
                'title' => 'Se ha comentado la incidencia del vehiculo ' . $comment->damage->vehicle->plate . ' : ' . $data['description']
            ]));
        }
        return $this->createDataResponse($data, Response::HTTP_CREATED);
    }

}
