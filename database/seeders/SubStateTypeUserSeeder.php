<?php

namespace Database\Seeders;

use App\Models\SubState;
use App\Models\TypeUserApp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubStateTypeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = $this->data();
        foreach($rows as $row){
            DB::table('sub_state_type_user_app')->insert([
                'sub_state_id' => $row['sub_state_id'],
                'type_user_app_id' => $row['type_user_app_id']
            ]);
        }
    }

    public function data(){
        return [
            [
                'sub_state_id' => SubState::CAMPA,
                'type_user_app_id' => TypeUserApp::RESPONSABLE_CAMPA
            ],
            [
                'sub_state_id' => SubState::PENDIENTE_LAVADO,
                'type_user_app_id' => TypeUserApp::RESPONSABLE_CAMPA
            ],
            [
                'sub_state_id' => SubState::MECANICA,
                'type_user_app_id' => TypeUserApp::RESPONSABLE_CAMPA
            ],
            [
                'sub_state_id' => SubState::CHAPA,
                'type_user_app_id' => TypeUserApp::RESPONSABLE_CAMPA
            ],
            [
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_user_app_id' => TypeUserApp::RESPONSABLE_CAMPA
            ],
            [
                'sub_state_id' => SubState::ITV,
                'type_user_app_id' => TypeUserApp::RESPONSABLE_CAMPA
            ],
            [
                'sub_state_id' => SubState::LIMPIEZA,
                'type_user_app_id' => TypeUserApp::RESPONSABLE_CAMPA
            ],
            [
                'sub_state_id' => SubState::SOLICITUD_DEFLEET,
                'type_user_app_id' => TypeUserApp::RESPONSABLE_CAMPA
            ],
            [
                'sub_state_id' => SubState::SIN_DOCUMENTACION,
                'type_user_app_id' => TypeUserApp::RESPONSABLE_CAMPA
            ],
            [
                'sub_state_id' => SubState::ALQUILADO,
                'type_user_app_id' => TypeUserApp::RESPONSABLE_CAMPA
            ],
            [
                'sub_state_id' => SubState::CHECK,
                'type_user_app_id' => TypeUserApp::RESPONSABLE_CAMPA
            ],
            [
                'sub_state_id' => SubState::CAMPA,
                'type_user_app_id' => TypeUserApp::OPERATOR_CAMPA
            ],
            [
                'sub_state_id' => SubState::MECANICA,
                'type_user_app_id' => TypeUserApp::WORKSHOP_MECHANIC
            ],
            [
                'sub_state_id' => SubState::CHAPA,
                'type_user_app_id' => TypeUserApp::WORKSHOP_CHAPA
            ],
            [
                'sub_state_id' => SubState::TRANSFORMACION,
                'type_user_app_id' => TypeUserApp::FLEETS
            ],
            [
                'sub_state_id' => SubState::LIMPIEZA,
                'type_user_app_id' => TypeUserApp::MOONS
            ],
        ];
    }
}
