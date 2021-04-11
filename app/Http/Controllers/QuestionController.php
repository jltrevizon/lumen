<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function getAll(){
        $user = User::with(['campa'])
                    ->where('id', Auth::id())
                    ->first();
        return Question::where('company_id', $user->campa->id)
                    ->get();
    }

    public function create(Request $request){
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

    public function delete($id){
        return Question::where('id', $id)
                        ->delete();

    }
}
