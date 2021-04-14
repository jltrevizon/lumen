<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class QuestionRepository {

    public function __construct()
    {

    }

    public function getAll(){
        $user = User::with(['campa'])
                    ->where('id', Auth::id())
                    ->first();
        return Question::where('company_id', $user->campa->id)
                    ->get();
    }

    public function create($request){
        $user = User::with(['campa'])
                    ->where('id', Auth::id())
                    ->first();
        $question = new Question();
        $question->company_id = $user->campa->company_id;
        $question->question = $request->json()->get('question');
        $question->description = $request->json()->get('description');
        $question->save();
        return $question;
    }
}
