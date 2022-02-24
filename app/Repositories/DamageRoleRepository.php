<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class DamageRoleRepository extends Repository {

    public function create($damageId, $roleId){
        DB::table('damage_role')->insert([
            'damage_id' => $damageId,
            'role_id' => $roleId
        ]);
    }

}