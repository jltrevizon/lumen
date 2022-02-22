<?php

namespace Database\Seeders;

use App\Models\StatePendingAuthorizationTask;
use Illuminate\Database\Seeder;

class StatePendingAuthorizationTaskSeeder extends Seeder
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
            StatePendingAuthorizationTask::create([
                'name' => $state
            ]);
        }
    }

    public function data(){
        return ['Pendiente', 'Aprobada', 'Rechazada'];
    }
}
