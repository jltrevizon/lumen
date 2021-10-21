<?php

namespace App\Repositories;

use App\Models\Accessory;
use App\Models\Comment;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CommentRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        return Comment::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }

    public function create($request){
        $comment = Comment::create($request->all());
        $comment->user_id = Auth::id();
        $comment->save();
        return $comment;
    }

}
