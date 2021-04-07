<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campa;

class CampaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campas = $this->data();
        foreach($campas as $campa){
            Campa::create([
                'company_id' => $campa['company_id'],
                'name' => $campa['name'],
                'active' => $campa['active']
            ]);
        }
    }

    public function data(){
        return [
            [
                'company_id' => 1,
                'name' => 'Madrid Centro',
                'active' => true
            ],
            [
                'company_id' => 1,
                'name' => 'Madrid Norte',
                'active' => true
            ],
            [
                'company_id' => 1,
                'name' => 'Madrid Sur',
                'active' => true
            ],
        ];
    }
}
