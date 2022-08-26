<?php

namespace App\Repositories\Invarat;

use App\Models\Company;
use App\Models\QuestionAnswer;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\TypeModelOrder;
use App\Models\Vehicle;
use App\Repositories\BrandRepository;
use App\Repositories\QuestionnaireRepository;
use App\Repositories\Repository;
use App\Repositories\VehicleModelRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class InvaratVehicleRepository extends Repository {

    public function __construct(
        BrandRepository $brandRepository,
        VehicleModelRepository $vehicleModelRepository,
        VehicleRepository $vehicleRepository,
        QuestionnaireRepository $questionnaireRepository

        )
    {
        $this->brandRepository = $brandRepository;
        $this->vehicleModelRepository = $vehicleModelRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function createVehicle($request){
        $vehicleExist = $this->vehicleRepository->getByPlate($request);
        if($vehicleExist) return $vehicleExist;
        $brand = $this->brandRepository->getByNameFromExcel($request->input('brand'));
        $vehicleModel = $this->vehicleModelRepository->getByNameFromExcel($brand->id, $request->input('vehicle_model'));
        $vehicle = Vehicle::create($request->all());
        $vehicle->company_id = Company::INVARAT;
        $vehicle->sub_state_id = SubState::PENDING_TEST_DINAMIC_INITIAL;
        $vehicle->vehicle_model_id= $vehicleModel->id;
        $vehicle->save();
        return $vehicle;
    }

    public function vehiclesByChannel($request){
        return Vehicle::with($this->getWiths($request->with))
            ->whereHas('pendingTasks', function(Builder $builder) {
                return $builder->where('state_pending_task_id','!=' , StatePendingTask::FINISHED);
            })
            ->where('type_model_order_id', '!=', TypeModelOrder::ALDFLEX)
            ->get()
            ->groupby('type_model_order_id');
    }

    /**
     * Generamos las preguntas, con respuestas vacías.
     *
     * @param $request
     * @return array|bool
     */
    public function createChecklistEmpty($request)
    {
        try{

            $questionnaire = $this->questionnaireRepository->create($request);
            $questions = $request->input('questions');

            foreach ($questions as $question) {
                $questionAnswer = new QuestionAnswer();
                $questionAnswer->questionnaire_id = $questionnaire['id'];
                $questionAnswer->question_id = $question['id'];
                $questionAnswer->response = 0;
                $questionAnswer->description = "";
                $questionAnswer->save();
            }

            return $questionnaire;

        }catch (\Exception $e){

            Log::debug("ERROR -->  ".$e->getMessage()." - ".$e->getFile()." - ".$e->getLine() );

            return [
                'message' => $e->getMessage(),
            ];

        }
    }

}
