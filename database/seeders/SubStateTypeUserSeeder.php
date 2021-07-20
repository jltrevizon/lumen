<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubStateTypeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = $this->data();
        foreach($rows as $row){
            DB::table('sub_state_type_user_app')->insert([
                'sub_state_id' => $row['sub_state_id'],
                'type_user_app_id' => $row['type_user_app_id']
            ]);
        }
    }

    public function data(){
        return [
            [
                'sub_state_id' => 1,
                'type_user_app_id' => 1
            ],
            [
                'sub_state_id' => 2,
                'type_user_app_id' => 1
            ],
            [
                'sub_state_id' => 3,
                'type_user_app_id' => 1
            ],
            [
                'sub_state_id' => 4,
                'type_user_app_id' => 1
            ],
            [
                'sub_state_id' => 5,
                'type_user_app_id' => 1
            ],
            [
                'sub_state_id' => 6,
                'type_user_app_id' => 1
            ],
            [
                'sub_state_id' => 7,
                'type_user_app_id' => 1
            ],
            [
                'sub_state_id' => 8,
                'type_user_app_id' => 1
            ],
            [
                'sub_state_id' => 9,
                'type_user_app_id' => 1
            ],
            [
                'sub_state_id' => 10,
                'type_user_app_id' => 1
            ],
            [
                'sub_state_id' => 11,
                'type_user_app_id' => 1
            ],
            [
                'sub_state_id' => 1,
                'type_user_app_id' => 2
            ],
            [
                'sub_state_id' => 3,
                'type_user_app_id' => 3
            ],
            [
                'sub_state_id' => 4,
                'type_user_app_id' => 4
            ],
            [
                'sub_state_id' => 5,
                'type_user_app_id' => 5
            ],
            [
                'sub_state_id' => 7,
                'type_user_app_id' => 6
            ],
        ];
    }
}
