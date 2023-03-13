<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeModelOrder;


class TypeModelSeeder2 extends Seeder
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
                'name' => $type['name']
            ]);
        }
    }

    public function data(){
        return [
           
            [
                'name' => 'ALD FLEX REACONDICIONADOS'
            ]
        ];
    }
}
