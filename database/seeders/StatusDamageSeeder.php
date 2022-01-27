<?php

namespace Database\Seeders;

use App\Models\StatusDamage;
use Illuminate\Database\Seeder;

class StatusDamageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = $this->data();
        foreach($statuses as $status){
            StatusDamage::updateOrCreate([
                'id' => $status['id']
            ],[
                'description' => $status['description']
            ]);
        }
    }

    public function data(){
        return [
            [
                'id' => 1, 
                'description' => 'Pendiente' 
            ],
            [ 
                'id' => 2,
                'description' => 'Cerrado' 
            ],
            [ 
                'id' => 3,
                'description' => 'Declinado' 
            ]
        ];
    }
}
