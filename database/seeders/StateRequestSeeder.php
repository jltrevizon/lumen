<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use App\Models\StateRequest;

class StateRequestSeeder extends Seeder
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
            StateRequest::create([
                'name' => $state['name']
            ]);
        }
    }

    public function data(){
        return [
            [ 'name' => 'Solicitado' ],
            [ 'name' => 'Aprobado']
        ];
    }
}
