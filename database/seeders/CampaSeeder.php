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
                'province_id' => $campa['province_id'],
                'active' => $campa['active']
            ]);
        }
    }

    public function data(){
        return [
            [
                'company_id' => 1,
                'name' => 'Rociauto',
                'province_id' => 9,
                'active' => true
            ],
            [
                'company_id' => 1,
                'name' => 'Vias Palante',
                'province_id' => 32,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Campa Leganés',
                'province_id' => 31,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Myr Coruña',
                'province_id' => 25,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Autoselec',
                'province_id' => 9,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Dekra Valencia',
                'province_id' => 46,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Motordos Las Palmas',
                'province_id' => 27,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Campa Loiu',
                'province_id' => 48,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Toquero Mallorca',
                'province_id' => 8,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Oskialia',
                'province_id' => 41,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Delotser',
                'province_id' => 9,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Talaveron',
                'province_id' => 41,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Delotser Madrid',
                'province_id' => 31,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Pro Motor Oliva',
                'province_id' => 46,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Myr Santiago',
                'province_id' => 25,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Motordos Tenerife',
                'province_id' => 39,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Dekra Zaragoza',
                'province_id' => 50,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Pullmancar',
                'province_id' => 31,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Toquero San Fernándo',
                'province_id' => 31,
                'active' => true
            ],[
                'company_id' => 1,
                'name' => 'Toquero Soto',
                'province_id' => 31,
                'active' => true
            ]
        ];
    }
}
