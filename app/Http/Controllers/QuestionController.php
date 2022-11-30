<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\User;
use App\Repositories\QuestionRepository;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class QuestionController extends Controller
{

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/questions/getall",
    *     tags={"questions"},
    *     summary="Get all type questions",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Question"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->questionRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'question' => 'required|string',
            'description' => 'required|string'
        ]);

        return $this->createDataResponse($this->questionRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function filter(Request $request){
        return $this->getDataResponse($this->questionRepository->filter($request), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return Question::where('id', $id)
                        ->delete();

    }
}
