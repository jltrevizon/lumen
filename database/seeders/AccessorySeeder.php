<?php

namespace Database\Seeders;

use App\Models\Accessory;
use App\Models\Reception;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AccessorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Accessory::factory()->count(2)->create();
    }
}
