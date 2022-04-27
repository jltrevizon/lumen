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
        $types = $this->data();
        foreach($types as $type){
            DamageType::create([
                'description' => $type
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
