<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Damage;


class StatusDamageUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Damage::where('status_damage_id', 3)->update([
        	'status_damage_id' => 1
        ]);
    }
}
