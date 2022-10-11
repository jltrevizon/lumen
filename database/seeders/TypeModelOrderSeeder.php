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
            TypeModelOrder::updateOrCreate([
                'id' => $type['id']
            ],[
                'name' => $type['name']
            ]);
        }
    }

    public function data(){
        return [
            [
                'id' => 1,
                'name' => 'BIPI'
            ],
            [
                'id' => 2,
                'name' => 'REDRIVE'
            ],
            [
                'id' => 3,
                'name' => '2ND'
            ],
            [
                'id' => 4,
                'name' => 'ALD Flex'
            ],
            [
                'id' => 5,
                'name' => 'CARMARKET'
            ],
            [
                'id' => 6,
                'name' => 'DEVOLUCIÓN'
            ],
            [
                'id' => 7,
                'name' => 'VO'
            ],
            [
                'id' => 8,
                'name' => 'VO-ENTREGADO-ALD-FLEX'
            ],
            [
                'id' => 9,
                'name' => 'ALD FLEX NUEVO'
            ]
        ];
    }
}
