<?php

namespace App\Repositories;

use App\Mail\NotificationDAMail;
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
        NotificationDAMail $notificationDAMail)
    {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->receptionRepository = $receptionRepository;
        $this->groupTaskRepository = $groupTaskRepository;
        $this->pendingTaskRepository = $pendingTaskRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->notificationDAMail = $notificationDAMail;
    }

    public function create($request){
        $questionnaire = $this->questionnaireRepository->create($request);
        $questions = $request->input('questions');
        $has_environment_label = null;
        foreach($questions as $question){
            $questionAnswer = new QuestionAnswer();
            $questionAnswer->questionnaire_id = $questionnaire['id'];
            $questionAnswer->question_id = $question['question_id'];
            $questionAnswer->task_id = $question['task_id'];
            $questionAnswer->response = $question['response'];
            $questionAnswer->description = $question['description'];
            $questionAnswer->save();
            if ($questionAnswer->question_id === 9) {
                $has_environment_label = $question['response'];
                $this->notificationDAMail->build($request->input('vehicle_id'));
            }
        }
        $reception = $this->receptionRepository->lastReception($request->input('vehicle_id'));

        $vehicle = $reception->vehicle;
        $vehicle->sub_state_id = SubState::CHECK;
        $vehicle->has_environment_label = $has_environment_label;
        $vehicle->save();

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
        if($request->input('task_id')){
            $groupTask = $this->groupTaskRepository->groupTaskByQuestionnaireId($request->input('questionnaire_id'));
            $this->pendingTaskRepository->updatePendingTaskFromValidation($groupTask, $request->input('last_task_id'), $request->input('task_id'));
        }
        $questionAnswer->update($request->all());
        return ['question_answer' => $questionAnswer];
    }

    public function updateResponse($request, $id){
        $questionAnswer = QuestionAnswer::findOrFail($id);
        $questionAnswer->update($request->all());
        return $questionAnswer;
    }
}
