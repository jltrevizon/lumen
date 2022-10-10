<?php

namespace Database\Seeders\Invarat;

use App\Models\SubState;
use Illuminate\Database\Seeder;

class RepairSubStateInvaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubState::create(array("name" => "Taller mecánica", "state_id" => 11));
        SubState::create(array("name" => "Taller carrocería", "state_id" => 11));
        SubState::create(array("name" => "ITV", "state_id" => 11));
    }
}
