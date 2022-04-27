<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatePendingTask;

class StatePendingTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = $this->data();
        foreach($states as $state){
            StatePendingTask::create([
                'name' => $state['name']
            ]);
        }
    }

    public function data(){
        return [
            ['name' => 'Pendiente'],
            ['name' => 'En curso'],
            ['name' => 'Terminada']
        ];
    }
}
