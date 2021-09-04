<?php

namespace Database\Seeders;

use App\Models\StateBudgetPendingTask;
use Illuminate\Database\Seeder;

class StateBudgetPendingTaskSeeder extends Seeder
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
            StateBudgetPendingTask::create([
                'name' => $state['name']
            ]);
        }
    }

    public function data(){
        return [
            ['name' => 'Pendiente'],
            ['name' => 'Aprobado'],
            ['name' => 'Declinado']
        ];
    }
}
