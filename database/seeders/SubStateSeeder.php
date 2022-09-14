<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use App\Models\SubState;

class SubStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subStates = $this->data();
        foreach ($subStates as $subState) {
            SubState::updateOrCreate([
                'id' => $subState['id']
            ], [
                'name' => $subState['name'],
                'state_id' => $subState['state_id'],
                'display_name' => $subState['display_name']
            ]);
        }
    }

    public function data()
    {
        return [
            [
                "id" => 1,
                "state_id" => 1,
                "name" => "Campa",
                "display_name" =>    "Campa"
            ],
            [
                "id" => 2,
                "state_id" => 1,
                "name" => "Pendiente Lavado",
                "display_name" =>    "Pendiente Lavado"
            ],
            [
                "id" => 3,
                "state_id" =>    2,
                "name" => "Mecánica",
                "display_name" =>    "Mecánica",
            ],
            [
                "id" => 4,
                "state_id" =>    2,
                "name" => "Chapa",
                "display_name" =>    "Chapa"
            ],
            [
                "id" => 5,
                "state_id" =>    2,
                "name" => "Transformación",
                "display_name" =>    "Transformación"
            ],
            [
                "id" => 6,
                "state_id" =>    2,
                "name" => "ITV",
                "display_name" =>    "ITV"
            ],
            [
                "id" => 7,
                "state_id" =>    2,
                "name" => "Limpieza",
                "display_name" =>    "Limpieza"
            ],
            [
                "id" => 8,
                "state_id" =>    3,
                "name" => "Defletado",
                "display_name" =>    "Defleet"
            ],
            [
                "id" => 9,
                "state_id" =>    4,
                "name" => "Sin documentación",
                "display_name" =>    "Estado sin documentación"
            ],
            [
                "id" => 10,
                "state_id" =>    5,
                "name" => "Alquilado",
                "display_name" =>    "Alquiler"
            ],
            [
                "id" => 11,
                "state_id" =>    6,
                "name" => "Check",
                "display_name" =>    "Check"
            ],
            [
                "id" => 12,
                "state_id" => 4,
                "name" => "Check pendiente",
                "display_name" =>    "Check pendiente"
            ],
            [
                "id" => 13,
                "state_id" =>    7,
                "name" => "Pendiente prueba dinámica inicial",
                "display_name" =>    "Pendiente prueba dinámica inicial"
            ],
            [
                "id" => 14,
                "state_id" =>    8,
                "name" => "Pendiente checklist incial",
                "display_name" =>    "Pendiente checklist incial"
            ],
            [
                "id" => 15,
                "state_id" =>    9,
                "name" => "Pendiente de presupuesto",
                "display_name" =>    "Pendiente de presupuesto"
            ],
            [
                "id" => 16,
                "state_id" =>    10,
                "name" => "Pendiente de autorización",
                "display_name" =>    "Pendiente de autorización"
            ],
            [
                "id" => 17,
                "state_id" =>    11,
                "name" => "En reparación",
                "display_name" =>    "En reparación"
            ],
            [
                "id" => 18,
                "state_id" =>    12,
                "name" => "Pendiente prueba dinámica final",
                "display_name" =>    "Pendiente prueba dinámica final"
            ],
            [
                "id" => 19,
                "state_id" =>    13,
                "name" => "Pendiente de check final",
                "display_name" =>    "Pendiente de check final"
            ],
            [
                "id" => 20,
                "state_id" =>    14,
                "name" => "Pendiente de certificado",
                "display_name" =>    "Pendiente de certificado"
            ],
            [
                "id" => 21,
                "state_id" =>    15,
                "name" => "Finalizado",
                "display_name" =>    "Finalizado"
            ],
            [
                "id" => 22,
                "state_id" =>    2,
                "name" => "Taller externo",
                "display_name" =>    "Taller externo"
            ],
            [
                "id" => 23,
                "state_id" =>    6,
                "name" => "Pre-disponible",
                "display_name" =>    "Pre-disponible"
            ],
            [
                "id" => 24,
                "state_id" =>    2,
                "name" => "Taller lunas",
                "display_name" =>    "Taller lunas"
            ],
            [
                "id" => 25,
                "state_id" =>    16,
                "name" => "Transporte",
                "display_name" =>    "Transporte"
            ],
            [
                "id" => 26,
                "state_id" =>    3,
                "name" => "Solicitado defleet",
                "display_name" =>    "Solicitado defleet"
            ]
        ];
    }
}
