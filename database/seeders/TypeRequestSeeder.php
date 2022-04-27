<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeRequest;

class TypeRequestSeeder extends Seeder
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
            TypeRequest::create([
                'name' => $type['name']
            ]);
        }
    }

    public function data(){
        return [
            [ 'name' => 'Defleet'],
            [ 'name' => 'Reserva']
        ];
    }
}
