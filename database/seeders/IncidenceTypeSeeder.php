<?php

namespace Database\Seeders;

use App\Models\IncidenceType;
use Illuminate\Database\Seeder;

class IncidenceTypeSeeder extends Seeder
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
            IncidenceType::create([
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
