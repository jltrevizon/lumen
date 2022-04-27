<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campa;
use App\Models\Company;

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
                'company_id' => Company::ALD,
                'name' => 'Rociauto',
                'province_id' => 9,
                'active' => true
            ],
            [
                'company_id' => Company::ALD,
                'name' => 'Vias Palante',
                'province_id' => 32,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Campa Leganés',
                'province_id' => 31,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Myr Coruña',
                'province_id' => 25,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Autoselec',
                'province_id' => 9,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Dekra Valencia',
                'province_id' => 46,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Motordos Las Palmas',
                'province_id' => 27,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Campa Loiu',
                'province_id' => 48,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Toquero Mallorca',
                'province_id' => 8,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Oskialia',
                'province_id' => 41,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Delotser',
                'province_id' => 9,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Talaveron',
                'province_id' => 41,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Delotser Madrid',
                'province_id' => 31,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Pro Motor Oliva',
                'province_id' => 46,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Myr Santiago',
                'province_id' => 25,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Motordos Tenerife',
                'province_id' => 39,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Dekra Zaragoza',
                'province_id' => 50,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Pullmancar',
                'province_id' => 31,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Toquero San Fernándo',
                'province_id' => 31,
                'active' => true
            ],[
                'company_id' => Company::ALD,
                'name' => 'Toquero Soto',
                'province_id' => 31,
                'active' => true
            ]
        ];
    }
}
