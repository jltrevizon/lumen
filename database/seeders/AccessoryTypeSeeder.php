<?php

namespace Database\Seeders;

use App\Models\AccessoryType;
use Illuminate\Database\Seeder;

class AccessoryTypeSeeder extends Seeder
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
            AccessoryType::create([
                'description' => $type
            ]);
        }
    }

    private function data(){
        return [
            'Accesorios',
            'Documentación'
        ];
    }
}
