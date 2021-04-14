<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return User::with(['campa'])
                    ->where('id', $id)
                    ->first();
    }
}
