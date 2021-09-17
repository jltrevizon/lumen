<?php

namespace Database\Seeders;

use App\Models\TypeModelOrder;
use Illuminate\Database\Seeder;

class TypeModelOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = $this->data();
        foreach($types as $type){
            TypeModelOrder::create([
                'name' => $type['name']
            ]);
        }
    }

    public function data(){
        return [
            [
                'name' => 'BIPI'
            ],
            [
                'name' => 'REDRIVE'
            ],
            [
                'name' => '2D'
            ],
            [
                'name' => 'ALD Flex'
            ]
        ];
    }
}
