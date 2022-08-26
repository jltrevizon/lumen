<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Question;
use App\Models\SubState;
use App\Models\Task;
use App\Models\TypeTask;
use Illuminate\Database\Seeder;

class QuestionsInvaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         *  QUESTIONS MECANICA
         */

        Question::create(array("company_id" => Company::INVARAT, "question" => "Estado general Motor (estanqueidad)", "description" => "Estado general Motor (estanqueidad)"));

        /**
         *  EXT - INT
         */

        Question::create(array("company_id" => Company::INVARAT, "question" => "Parte Frontal", "description" => "Parte Frontal"));
        Question::create(array("company_id" => Company::INVARAT, "question" => "Lateral derecho", "description" => "Lateral derecho"));
        Question::create(array("company_id" => Company::INVARAT, "question" => "Parte trasera", "description" => "Parte trasera"));
        Question::create(array("company_id" => Company::INVARAT, "question" => "Lateral Izquierdo", "description" => "Lateral Izquierdo"));
        Question::create(array("company_id" => Company::INVARAT, "question" => "Techo", "description" => "Techo"));

        /**
         * NEUMATICOS
         */

        // Necesitan tener la parte de neumaticos desglosada, no en una única pregunta.
        $question_16 = Question::query()
            ->where("company_id", Company::INVARAT)
            ->where("question","Estado neumáticos, presiones, aspecto y desgaste y rueda de repuesto/kit antipinchazos")
            ->first();

        if($question_16){
            $question_16->delete();
        }


        Question::create(array("company_id" => Company::INVARAT, "question" => "Estado neumáticos", "description" => "Estado neumáticos"));
        Question::create(array("company_id" => Company::INVARAT, "question" => "Profundidad", "description" => "Profundidad"));
        Question::create(array("company_id" => Company::INVARAT, "question" => "Rueda de repuesto/kit antipinchazos", "description" => "Rueda de repuesto/kit antipinchazos"));



    }
}
