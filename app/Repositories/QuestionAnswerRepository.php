<?php

namespace App\Repositories;

use App\Models\QuestionAnswer;
use App\Models\Questionnaire;
use App\Models\SubState;
use Exception;

class QuestionAnswerRepository {

    public function __construct(
        QuestionnaireRepository $questionnaireRepository,
        ReceptionRepository $receptionRepository,
        GroupTaskRepository $groupTaskRepository,
        PendingTaskRepository $pendingTaskRepository,
        VehicleRepository $vehicleRepository,
        AccessoryRepository $accessoryRepository)
    {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->receptionRepository = $receptionRepository;
        $this->accessoryRepository = $accessoryRepository;
        $this->groupTaskRepository = $groupTaskRepository;
        $this->pendingTaskRepository = $pendingTaskRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function create($request){
        $questionnaire = $this->questionnaireRepository->create($request);
        $questions = $request->input('questions');
        foreach($questions as $question){
            $questionAnswer = new QuestionAnswer();
            $questionAnswer->questionnaire_id = $questionnaire['id'];
            $questionAnswer->question_id = $question['question_id'];
            $questionAnswer->task_id = $question['task_id'];
            $questionAnswer->response = $question['response'];
            $questionAnswer->description = $question['description'];
            $questionAnswer->save();
        }
        $reception = $this->receptionRepository->lastReception($request->input('vehicle_id'));

        if($request->input('has_accessories')){
            $this->receptionRepository->update($reception['id']);
            $this->accessoryRepository->create($reception['id'], $request->input('accessories'));
        }
        $this->vehicleRepository->updateSubState($request->input('vehicle_id'), SubState::CHECK);
        return [
            'questionnaire' => $questionnaire
        ];
    }

    public function createChecklist($request){
        $questionnaire = $this->questionnaireRepository->create($request);
        $questions = $request->input('questions');
        foreach($questions as $question){
            $questionAnswer = new QuestionAnswer();
            $questionAnswer->questionnaire_id = $questionnaire['id'];
            $questionAnswer->question_id = $question['question_id'];
            $questionAnswer->response = $question['response'];
            $questionAnswer->description = $question['description'];
            $questionAnswer->save();
        }
        $questionnaireComplete = Questionnaire::with(['questionAnswers.question','vehicle.lastOrder']) 
                ->findOrFail($questionnaire['id']);
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'https://devgsp20.invarat.com/api/createChecklist',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Zm9jdXM6aW52YXJhdGZvY3Vz'
                ],
                'body' => json_encode($questionnaireComplete)
            ]
        );
        return [
            'message' => 'Ok',
            'message_gsp' => $response
        ];
    }

    public function update($request, $id){
        $questionAnswer = QuestionAnswer::findOrFail($id);
        $groupTask = $this->groupTaskRepository->groupTaskByQuestionnaireId($request->input('questionnaire_id'));
        $this->pendingTaskRepository->updatePendingTaskFromValidation($groupTask, $request->input('last_task_id'), $request->input('task_id'));
        $questionAnswer->update($request->all());
        return ['question_answer' => $questionAnswer];
    }

    public function updateResponse($request, $id){
        $questionAnswer = QuestionAnswer::findOrFail($id);
        $questionAnswer->update($request->all());
        return $questionAnswer;
    }
}
