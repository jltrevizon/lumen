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
            StatusDamage::create([
                'description' => $status['description']
            ]);
        }
    }

    public function data(){
        return [
            [ 'description' => 'Pendiente' ],
            [ 'description' => 'Aprobado' ],
            [ 'description' => 'Declinado' ]
        ];
    }
}
