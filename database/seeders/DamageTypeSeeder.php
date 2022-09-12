<?php

namespace Database\Seeders;

use App\Models\DamageType;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DamageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types[] = [
            'id' => 1,
            'description' => 'Tarea'
        ];
        $types[] = [
            'id' => 2,
            'description' => 'Anotación'
        ];
        foreach($types as $type){
            DamageType::updateOrCreate([
                'id' => $type['id']
            ], [
                'description' => $type['description']
            ]);
        }
    }

    public function data(){
        return [
            'Tarea',
            'Anotación'
        ];
    }
}
