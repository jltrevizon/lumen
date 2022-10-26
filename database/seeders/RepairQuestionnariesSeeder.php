<?php

namespace Database\Seeders;

use App\Models\Questionnaire;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RepairQuestionnariesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionnaires = Questionnaire::whereNull('reception_id')->whereNotNull('vehicle_id')
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereRaw(DB::raw('id in (SELECT max(q2.id) from questionnaires q2 group by q2.vehicle_id )'))
            ->get();
        Log::debug($questionnaires);

        foreach ($questionnaires as $key => $questionnaire) {
            if ($questionnaire->vehicle?->lastReception?->id) {
                $questionnaire->reception_id = $questionnaire->vehicle->lastReception->id;
                $questionnaire->save();
            }
        }
    }
}
