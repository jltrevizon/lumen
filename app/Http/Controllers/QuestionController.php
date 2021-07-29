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

    public function getAll(Request $request){
        return $this->getDataResponse($this->questionRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'question' => 'required|string',
            'description' => 'required|string'
        ]);

        return $this->createDataResponse($this->questionRepository->create($request), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return Question::where('id', $id)
                        ->delete();

    }
}
