<?php

namespace App\Repositories;

use App\Mail\NotificationDAMail;
use App\Mail\NotificationItvMail;
use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\QuestionAnswer;
use App\Models\Questionnaire;
use App\Models\Role;
use App\Models\StatePendingTask;
use App\Repositories\StateChangeRepository;
use App\Models\SubState;
use App\Models\TypeModelOrder;
use App\Models\User;
use App\Models\Vehicle;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuestionAnswerRepository
{

    public function __construct(
        TaskRepository $taskRepository,
        QuestionnaireRepository $questionnaireRepository,
        ReceptionRepository $receptionRepository,
        GroupTaskRepository $groupTaskRepository,
        PendingTaskRepository $pendingTaskRepository,
        VehicleRepository $vehicleRepository,
        NotificationDAMail $notificationDAMail,
        NotificationItvMail $notificationItvMail,
        SquareRepository $squareRepository,
        StateChangeRepository $stateChangeRepository
    ) {
        $this->taskRepository = $taskRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->receptionRepository = $receptionRepository;
        $this->groupTaskRepository = $groupTaskRepository;
        $this->pendingTaskRepository = $pendingTaskRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->notificationDAMail = $notificationDAMail;
        $this->notificationItvMail = $notificationItvMail;
        $this->stateChangeRepository = $stateChangeRepository;
        $this->squareRepository = $squareRepository;
    }

    public function create($request)
    {
        $questionnaire = null;            
        $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
        $this->vehicleRepository->newReception($vehicle->id, null, false, true);

        if ($vehicle->type_model_order_id === TypeModelOrder::ALDFLEX) {
            $questionnaire = $this->questionnaireRepository->create($request);
            $questions = $request->input('questions');
            $has_environment_label = null;
            foreach ($questions as $question) {
                $questionAnswer = new QuestionAnswer();
                $questionAnswer->questionnaire_id = $questionnaire['id'];
                $questionAnswer->question_id = $question['question_id'];
                $questionAnswer->task_id = $question['task_id'];
                $questionAnswer->response = $question['response'];
                $questionAnswer->description = $question['description'];
                $questionAnswer->save();
                if ($questionAnswer->question_id === 9) {
                    $has_environment_label = $question['response'];
                }
    
                if ($questionAnswer->question_id === 4 && $question['response'] == 1) {
                    $this->notificationItvMail->build($request->input('vehicle_id'));
                }
            }
        
            $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
    
            $pendingTasks = $vehicle->lastGroupTask->pendingTasks ?? null;
            if ($pendingTasks) {
                foreach ($pendingTasks as $key => $pending_task) {
                    $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
                    $pending_task->order = -1;
                    if (is_null($pending_task->datetime_pending)) {
                        $pending_task->datetime_pending = date('Y-m-d H:i:s');
                    }
                    if (is_null($pending_task->datetime_start)) {
                        $pending_task->datetime_start = date('Y-m-d H:i:s');
                    }
                    if (is_null($pending_task->datetime_finish)) {
                        $pending_task->datetime_finish = date('Y-m-d H:i:s');
                    }
                    if (is_null($pending_task->user_start_id)) {
                        $pending_task->user_start_id = Auth::id();
                    }
                    if (is_null($pending_task->user_end_id)) {
                        $pending_task->user_end_id = Auth::id();
                    }
                    $pending_task->save();
                }
            }
    

            $groupTask = GroupTask::findOrFail($vehicle->lastGroupTask->id);
    
            $user = Auth::user();
            $this->vehicleRepository->updateCampa($request->input('vehicle_id'), $user['campas'][0]['id']);
    
            $tasks = $request->input('tasks');
            $groupTaskId = $groupTask->id;
            $vehicleId = $request->input('vehicle_id');
    
            $user = User::where('role_id', Role::CONTROL)
                ->first();
            $vehicle = Vehicle::findOrFail($vehicleId);
            $isPendingTaskAssign = false;
            $order = 1;
    
            foreach ($tasks as $task) {
                $pending_task = new PendingTask();
                $pending_task->vehicle_id = $vehicleId;
                $pending_task->reception_id = $vehicle->lastReception->id;
                $pending_task->campa_id = $vehicle->campa_id;
                $taskDescription = $this->taskRepository->getById([], $task['task_id']);
                $pending_task->task_id = $task['task_id'];
                $pending_task->approved = $task['approved'];
                $pending_task->created_from_checklist = true;
    
                $question_answer = QuestionAnswer::where('task_id', $task['task_id'])
                    ->where('questionnaire_id', $vehicle->lastQuestionnaire?->id)->first();
                if (!is_null($question_answer)) {
                    $pending_task->question_answer_id = $question_answer->id;
                }
                Log::debug($task);
                if ($task['approved'] == true && $isPendingTaskAssign == false) {
                    if (!isset($task['without_state_pending_task'])) {
                        $pending_task->state_pending_task_id = StatePendingTask::PENDING;
                    }
                    $pending_task->datetime_pending = date('Y-m-d H:i:s');
                    $isPendingTaskAssign = true;
                }
                $pending_task->group_task_id = $groupTaskId;
                $pending_task->user_id = $user->id;
                $pending_task->duration = $taskDescription['duration'];
                if ($task['approved'] == true) {
                    $pending_task->order = $order;
                    $order++;
                }
                $pending_task->save();
            }
    
            $this->vehicleRepository->updateBack($request);
    
            $vehicle = Vehicle::find($request->input('vehicle_id'));
            $this->stateChangeRepository->updateSubStateVehicle($vehicle);
            $vehicle->has_environment_label = $has_environment_label;
            $vehicle->save();
        }
       
        if ($request->input('square_id')) {
            $this->squareRepository->update($request, $request->input('square_id'));
        }
        return [
            'questionnaire' => $questionnaire
        ];
    }

    public function createChecklist($request)
    {
        $questionnaire = $this->questionnaireRepository->create($request);
        $questions = $request->input('questions');
        foreach ($questions as $question) {
            $questionAnswer = new QuestionAnswer();
            $questionAnswer->questionnaire_id = $questionnaire['id'];
            $questionAnswer->question_id = $question['question_id'];
            $questionAnswer->response = $question['response'];
            $questionAnswer->description = $question['description'];
            $questionAnswer->save();
        }
        $questionnaireComplete = Questionnaire::with(['questionAnswers.question', 'vehicle.lastOrder'])
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

    public function update($request, $id)
    {
        $questionAnswer = QuestionAnswer::findOrFail($id);
        if ($request->input('task_id')) {
            $groupTask = $this->groupTaskRepository->groupTaskByQuestionnaireId($request->input('questionnaire_id'));
            $this->pendingTaskRepository->updatePendingTaskFromValidation($groupTask, $request->input('last_task_id'), $request->input('task_id'));
        }
        $questionAnswer->update($request->all());
        return ['question_answer' => $questionAnswer];
    }

    /**
     * 11, 2, 3, 4, 41, 5, 6, 7, 8
     */
    public function updateResponse($request, $id)
    {
        $questionAnswer = QuestionAnswer::findOrFail($id);
        $questionAnswer->update($request->all());
        $pendingTask = PendingTask::where('question_answer_id', $questionAnswer->id)->first();
        if (!is_null($pendingTask)) {
            $pendingTask->approved = $questionAnswer->response;
            $pendingTask->save();
            $vehicle = $pendingTask->vehicle;
        } else if (!!$questionAnswer->response && !!$questionAnswer->task_id) {
            $vehicle = $questionAnswer->questionnaire->vehicle;
            $pending_task = new PendingTask();
            $pending_task->question_answer_id = $questionAnswer->id;
            $pending_task->vehicle_id = $vehicle->id;
            $pending_task->reception_id = $vehicle->lastReception->id;
            $pending_task->campa_id = $vehicle->campa_id;
            $taskDescription = $this->taskRepository->getById([], $questionAnswer->task_id);
            $pending_task->task_id = $questionAnswer->task_id;
            $pending_task->duration = $taskDescription['duration'];
            $pending_task->approved = $questionAnswer->response;
            $pending_task->created_from_checklist = true;

            $count = count($vehicle->lastGroupTask->approvedPendingTasks);

            if (!!$pending_task->approved && $count == 0) {
                $pending_task->state_pending_task_id = StatePendingTask::PENDING;
                $pending_task->datetime_pending = date('Y-m-d H:i:s');
            }
            $pending_task->group_task_id = $vehicle->lastGroupTask->id;
            $pending_task->user_id = Auth::id();
            if (!!$pending_task->approved) {
                $pending_task->order = $count + 1;
            }
            $pending_task->save();
            if ($pending_task->state_pending_task_id == StatePendingTask::PENDING) {
                $this->stateChangeRepository->updateSubStateVehicle($vehicle);
            }
            $pendingTask = $pending_task;
        }
        if(isset($variable)) {
            foreach ($vehicle->lastGroupTask->defaultOrderApprovedPendingTasks as $key => $value) {
                $value->order = $key + 1;
                $value->save();
            }    
        }
        return $questionAnswer;
    }
}
