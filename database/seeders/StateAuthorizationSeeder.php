<?php

namespace Database\Seeders;

use App\Models\StateAuthorization;
use Illuminate\Database\Seeder;

class StateAuthorizationSeeder extends Seeder
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
            StateAuthorization::create([
                'name' => $state
            ]);
        }
    }

    private function data(){
        return ['Pendiente', 'Aprobado','Rechazado'];
    }
}
