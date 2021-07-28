<?php

namespace App\Repositories;

use App\Models\QuestionAnswer;
use Exception;

class QuestionAnswerRepository {

    public function __construct(
        QuestionnaireRepository $questionnaireRepository,
        ReceptionRepository $receptionRepository,
        AccessoryRepository $accessoryRepository)
    {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->receptionRepository = $receptionRepository;
        $this->accessoryRepository = $accessoryRepository;
    }

    public function create($request){
        try {
            $questionnaire = $this->questionnaireRepository->create($request->input('vehicle_id'));
            $questions = $request->input('questions');
            foreach($questions as $question){
                $questionAnswer = new QuestionAnswer();
                $questionAnswer->questionnaire_id = $questionnaire;
                $questionAnswer->question_id = $question['question_id'];
                $questionAnswer->response = $question['response'];
                $questionAnswer->description = $question['description'];
                $questionAnswer->save();
            }
            $reception = $this->receptionRepository->lastReception($request->input('vehicle_id'));

            if($request->input('has_accessories')){
                $this->receptionRepository->update($reception['id']);
                $this->accessoryRepository->create($reception['id'], $request->input('accessories'));
            }
            return [
                'message' => 'Ok'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        $questionAnswer = QuestionAnswer::findOrFail($id);
        $questionAnswer->update($request->all());
        return ['question_answer' => $questionAnswer];
    }
}
