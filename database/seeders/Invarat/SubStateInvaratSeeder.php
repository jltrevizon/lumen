<?php

namespace Database\Seeders\Invarat;

use App\Models\SubState;
use Illuminate\Database\Seeder;

class SubStateInvaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubState::create(array("name" => "No autorizado", "state_id" => 17));
        SubState::create(array("name" => "Pendiente de perito", "state_id" => 18));
    }
}
