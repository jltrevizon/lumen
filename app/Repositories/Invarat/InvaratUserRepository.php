<?php

namespace App\Repositories\Invarat;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;

class InvaratUserRepository {

    public function __construct()
    {

    }

    public function createUser($email, $workshopId){
        $user = new User();
        $user->role_id = Role::CAMPA_MANAGET;
        $user->email = $email;
        $user->workshop_id = $workshopId;
        $user->company_id = Company::INVARAT;
        $user->password = app('hash')->make('Secret123**');
        $user->save();
        return $user;
    }

}
