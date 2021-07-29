<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Question;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class QuestionRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        $user = User::with($this->getWiths($request->with))
                    ->findOrFail(Auth::id());
        $questions = Question::where('company_id', $user->company_id)
                    ->get();
        if(count($questions) > 0) return $questions;
        else return Question::where('company_id', Company::ALD)->get();
    }

    public function create($request){
        $user = User::findOrFail(Auth::id());
        $question = new Question();
        $question->company_id = $user->company_id;
        $question->question = $request->input('question');
        $question->description = $request->input('description');
        $question->save();
        return $question;
    }
}
