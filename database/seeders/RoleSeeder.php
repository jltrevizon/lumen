<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = $this->data();
        foreach($roles as $role){
            Role::create([
                'description' => $role['description']
            ]);
        }
    }

    public function data(){
        return [
            ['description' => 'Admin'],
            ['description' => 'Gestor Global'],
            ['description' => 'Gestor Campa'],
            ['description' => 'User App'],
            ['description' => 'Recepción'],
            ['description' => 'Comercial'],
            ['description' => 'Invarat']
        ];
    }
}
