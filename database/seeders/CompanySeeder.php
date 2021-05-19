<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = $this->data();
        foreach($companies as $company){
            Company::create([
                'name' => $company['name'],
                'tradename' => $company['tradename'],
                'address' => $company['address'],
                'nif' => $company['nif'],
                'location' => $company['location'],
                'phone' => $company['phone']

            ]);
        }
    }

    public function data(){
        return [
            [
                'name' => 'ALD Automotive',
                'tradename' => 'ALD Automotive',
                'address' => ' Ctra. de Pozuelo, 32, 28220 Majadahonda, Madrid',
                'nif' => '58463147H',
                'location' => 'Majadahonda',
                'phone' => 917097000
            ]
        ];
    }
}
