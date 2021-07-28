<?php

namespace Database\Seeders;

use App\Models\OperationType;
use Illuminate\Database\Seeder;

class OperationTypeSeeder extends Seeder
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
            OperationType::create([
                'name' => $type['name']
            ]);
        }
    }

    public function data(){
        return [
            [ 'name' => 'Reparar' ],
            [ 'name' => 'Sustituir' ]
        ];
    }
}
