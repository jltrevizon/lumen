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
        foreach ($roles as $role) {
            Role::updateOrCreate([
                'id' => $role['id']
            ], [
                'description' => $role['description']
            ]);
        }
    }

    public function data()
    {
        return [
            [
                'id' => 1,
                'description' => 'Admin'
            ],
            [
                'id' => 2,
                'description' => 'Gestor Global'
            ],
            [
                'id' => 3,
                'description' => 'Gestor Campa'
            ],
            [
                'id' => 4,
                'description' => 'Operario'
            ],
            [
                'id' => 5,
                'description' => 'Recepción'
            ],
            [
                'id' => 6,
                'description' => 'Comercial'
            ],
            [
                'id' => 7,
                'description' => 'Invarat'
            ],
            [
                'id' => 8,
                'description' => 'Taller mecánico'
            ],
            [
                'id' => 9,
                'description' => 'Taller carrocería'
            ],
            [
                'id' => 10,
                'description' => 'Tecnico'
            ]
        ];
    }
}
