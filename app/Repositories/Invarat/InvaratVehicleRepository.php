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
use Illuminate\Support\Facades\DB;
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


    public function getVehicleResults($request){

        $service = $request->service;

        $vehicles = DB::select(
            DB::raw('
            select
				a.id,
				count(*) as cantidad,
				c.`name` as service_name,
                c.id as type_model_order_id,
                d.id as sub_state_id,
				d.`name` as task_name,
                (
                    CASE
                        WHEN DATEDIFF((SELECT max(datetime_start) from pending_tasks e where e.state_pending_task_id = 2 and e.vehicle_id = a.id), now()) > -9 THEN "1"
                        WHEN DATEDIFF((SELECT max(datetime_start) from pending_tasks e where e.state_pending_task_id = 2 and e.vehicle_id = a.id), now()) < -9 THEN "2"
                        ELSE "3"
                    END
                ) AS total
                from vehicles a,type_model_orders c, sub_states d
                where a.type_model_order_id = c.id
                and a.sub_state_id = d.id
                and a.company_id = 2
                and a.type_model_order_id = :service
                and (SELECT max(e.id) from pending_tasks e where e.state_pending_task_id != 3 and e.vehicle_id = a.id) > 0
                GROUP BY  a.sub_state_id, total
                ORDER BY total DESC'
            ), array('service' => $service)
        );

        return $vehicles;

    }

    public function getVehicleDetails($request){

        $tiempo = $request->tiempo;
        $v_compare = -9;

        if($tiempo == "1"){
            $t_compare = '>';
        }else{
            $t_compare = '<';
        }

        $vehicles = DB::select(
            DB::raw('
            select
                a.plate as matricula,
                c.`name` as canal,
                e.`name` as modelo,
                f.`name` as ubicación,
                a.created_at as fecha_entrada,
                (SELECT max(g.observations) from pending_tasks g where g.state_pending_task_id != 3 and g.vehicle_id = a.id) as observaciones
            from vehicles a, type_model_orders c, sub_states d, vehicle_models e, campas f
            where a.type_model_order_id = c.id
            and a.sub_state_id = d.id
            and a.vehicle_model_id = e.id
            and a.campa_id = f.id
            and a.company_id = 2
            and a.sub_state_id = :sub_state
            and a.type_model_order_id = :type_model
            and (SELECT max(e.id) from pending_tasks e where e.state_pending_task_id != 3 and e.vehicle_id = a.id) > 0
            and (DATEDIFF((SELECT max(datetime_start) from pending_tasks e where e.state_pending_task_id = 2 and e.vehicle_id = a.id), now()))
            '.$t_compare.' :t_compare'
            ), array(
                't_compare' => $v_compare,
                'sub_state' => $request->sub_state_id,
                'type_model' => $request->type_model_order_id
            )
        );

        return $vehicles;

    }
}
