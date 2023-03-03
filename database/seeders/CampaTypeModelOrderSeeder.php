<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CampaTypeModelOrder;
use App\Models\TypeModelOrder;

class CampaTypeModelOrderSeeder extends Seeder
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
            CampaTypeModelOrder::updateOrCreate([
                'campa_id' => $type['campa_id'],
                'type_model_order_id' => $type['type_model_order_id']
            ]);
        }
    }

    public function data(){
        $type_model = TypeModelOrder::where('name', 'ALD FLEX REACONDICIONADOS')->first();
        return [
           
            [
                'campa_id' => 3,
                'type_model_order_id' => $type_model->id,
            ],
            [
                'campa_id' => 21,
                'type_model_order_id' => $type_model->id,
            ]
        ];
    }
}
