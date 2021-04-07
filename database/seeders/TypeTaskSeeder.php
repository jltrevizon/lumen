<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeTask;

class TypeTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type_tasks = $this->data();
        foreach($type_tasks as $type_task){
            TypeTask::create([
                'name' => $type_task['name']
            ]);
        }
    }

    public function data(){
        return [
            [ 'name' => 'Accesorias' ],
            [ 'name' => 'Especiales' ]
        ];
    }
}
