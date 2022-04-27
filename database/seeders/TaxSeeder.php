<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxes = $this->data();
        foreach($taxes as $tax){
            Tax::create([
                'name' => $tax['name'],
                'value' => $tax['value'],
                'description' => $tax['description']
            ]);
        }
    }

    public function data(){
        return [
            [
                'name' => '21%',
                'value' => 21,
                'description' => 'IVA general'
            ],
            [
                'name' => '10%',
                'value' => 10,
                'description' => 'IVA reducido'
            ],
            [
                'name' => '4%',
                'value' => 4,
                'description' => 'IVA superreducido'
            ],
            [
                'name' => '7%',
                'value' => 7,
                'description' => 'IGIC general'
            ],
            [
                'name' => '3%',
                'value' => 3,
                'description' => 'IGIC reducido'
            ],
            [
                'name' => '0%',
                'value' => 0,
                'description' => 'IGIC tipo cero'
            ],
        ];
    }
}
