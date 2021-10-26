<?php

namespace App\Repositories;

use App\Models\Incidence;
use App\Models\LoginLog;
use Exception;

class LoginLogRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        return LoginLog::with($request->with)
                ->filter($request->all())
                ->paginate();
    }

}
