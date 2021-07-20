<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\User;
use App\Repositories\QuestionRepository;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function getAll(){
        return $this->questionRepository->getAll();
    }

    public function create(Request $request){

        $this->validate($request, [
            'question' => 'required|string',
            'description' => 'required|string'
        ]);

        return $this->questionRepository->create($request);
    }

    public function delete($id){
        return Question::where('id', $id)
                        ->delete();

    }
}
