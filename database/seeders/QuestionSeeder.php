<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = $this->data();
        foreach($questions as $question){
            Question::create([
                'company_id' => 1,
                'question' => $question['question'],
                'description' => $question['description']
            ]);
        }
    }

    public function data(){
        return [
            ['question' => '¿El vehículo viene con su documentación?', 'description' => '¿El vehículo viene con su documentación?'],
            ['question' => '¿Según los estándares de ALD el vehículo necesita de reparación de carrocería?', 'description' => '¿Según los estándares de ALD el vehículo necesita de reparación de carrocería?'],
            ['question' => '¿Según los estándares de ALD el vehículo requiere de intervención mecánica o revisión?', 'description' => '¿Según los estándares de ALD el vehículo requiere de intervención mecánica o revisión?'],
            ['question' => '¿Según los estándares de ALD requiere pasar una ITV?','description' => '¿Según los estándares de ALD requiere pasar una ITV?'],
            ['question' => '¿Requiere el vehículo de alguna limpieza especial?','description' => '¿Requiere el vehículo de alguna limpieza especial?'],
            ['question' => '¿Presenta el vehículo algún tipo de rotulación que no sea de Carflex o Reflex?','description' => '¿Presenta el vehículo algún tipo de rotulación que no sea de Carflex o Reflex?'],
            ['question' => '¿El vehículo tiene instalado algún accesorio?', 'description' => '¿El vehículo tiene instalado algún accesorio?'],

        ];
    }
}
