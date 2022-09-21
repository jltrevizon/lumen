<?php

namespace Database\Seeders;

use App\Models\Reception;
use Illuminate\Database\Seeder;

class RepairTypeReceptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reception::where('finished', 1)->update([
            'type_reception_id' => 1
        ]);
    }
}
