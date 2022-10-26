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
        $user = User::findOrFail(Auth::id());
        return Question::with($this->getWiths($request->with))->where('company_id', $user->company_id)
                    ->get();
    }

    public function create($request){
        $question = Question::create($request->all());
        return $question;
    }

    public function filter($request){
        return Question::with($this->getWiths($request->with))
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }
}
