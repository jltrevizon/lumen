<?php

namespace Database\Seeders;

use App\Models\TypeReception;
use Illuminate\Database\Seeder;

class TypeReceptionSeeder extends Seeder
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
            TypeReception::updateOrCreate([
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
                'name' => 'Checklist'
            ],
            [
                'id' => 2,
                'name' => 'Pendiente checklist'
            ]
        ];
    }
}
