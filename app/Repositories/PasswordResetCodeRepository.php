<?php

namespace App\Repositories;

use App\Models\PasswordResetCode;
use App\Models\Tax;

class PasswordResetCodeRepository extends Repository {

    public function getAll($request){
        return PasswordResetCode::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }

}
