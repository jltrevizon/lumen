<?php

namespace Database\Seeders\Invarat;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateInvaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create(array("name" => "No autorizado", "company_id" => 2, 'type' => 1));
        State::create(array("name" => "Pendiente de perito", "company_id" => 2, 'type' => 1));
    }
}
