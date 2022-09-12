<?php

namespace App\Repositories;

use App\Models\Damage;
use App\Models\PendingTask;
use App\Models\Reception;
use App\Models\SubState;
use App\Models\TradeState;
use App\Models\Vehicle;
use App\Models\StatePendingTask;
use App\Models\StatusDamage;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CategoryRepository;
use App\Repositories\DefleetVariableRepository;
use App\Repositories\GroupTaskRepository;
use App\Repositories\StateRepository;
use App\Repositories\BrandRepository;
use App\Repositories\VehicleModelRepository;
use App\Repositories\UserRepository;
use App\Repositories\TypeModelOrderRepository;
use App\Repositories\DeliveryVehicleRepository;
use App\Repositories\VehicleExitRepository;
use App\Repositories\StateChangeRepository;

use App\Repositories\CampaRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Environment\Console;

class VehicleRepository extends Repository
{

    public function __construct(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        DefleetVariableRepository $defleetVariableRepository,
        StateRepository $stateRepository,
        GroupTaskRepository $groupTaskRepository,
        BrandRepository $brandRepository,
        VehicleModelRepository $vehicleModelRepository,
        TypeModelOrderRepository $typeModelOrderRepository,
        DeliveryVehicleRepository $deliveryVehicleRepository,
        VehicleExitRepository $vehicleExitRepository,
        CampaRepository $campaRepository,
        DeliveryNoteRepository $deliveryNoteRepository,
        SquareRepository $squareRepository,
        StateChangeRepository $stateChangeRepository,
        HistoryLocationRepository $historyLocationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->defleetVariableRepository = $defleetVariableRepository;
        $this->stateRepository = $stateRepository;
        $this->groupTaskRepository = $groupTaskRepository;
        $this->brandRepository = $brandRepository;
        $this->vehicleModelRepository = $vehicleModelRepository;
        $this->campaRepository = $campaRepository;
        $this->typeModelOrderRepository = $typeModelOrderRepository;
        $this->deliveryVehicleRepository = $deliveryVehicleRepository;
        $this->vehicleExitRepository = $vehicleExitRepository;
        $this->squareRepository = $squareRepository;
        $this->deliveryNoteRepository = $deliveryNoteRepository;
        $this->stateChangeRepository = $stateChangeRepository;
        $this->historyLocationRepository = $historyLocationRepository;
    }

    public function getAll($request)
    {
        $user = $this->userRepository->getById($request, Auth::id());
        $vehicles = Vehicle::with($this->getWiths($request->with))
            ->byCampasOfUser($user->campas->pluck('id')->toArray())
            ->paginate($request->input('per_page'));
        return ['vehicles' => $vehicles];
    }

    public function getById($request, $id)
    {
        return Vehicle::with($this->getWiths($request->with) ?? [])->findOrFail($id);
    }

    public function filterVehicle($request)
    {
        $query = Vehicle::with($this->getWiths($request->with))
            ->filter($request->all());
        if ($request->input('budgetLastGroupTaskIds')) {
            $query->selectRaw('vehicles.*, (SELECT MAX(b.id) FROM budget_pending_tasks b, pending_tasks p WHERE p.vehicle_id = vehicles.id and p.id = b.pending_task_id) as budget_pending_task_id')
                ->orderBy('budget_pending_task_id', 'desc');
        } else {
            $query->selectRaw('vehicles.*, (SELECT MAX(r.id) FROM receptions r WHERE r.vehicle_id = vehicles.id) as reception_id')
                ->orderBy('reception_id', 'desc');
        }
        if ($request->input('noPaginate')) {
            $vehicles = [
                'data' => $query->get()
            ];
        } else {
            $vehicles =  $query->paginate($request->input('per_page') ?? 5);
        }
        return ['vehicles' => $vehicles];
    }

    public function filterVehicleDownloadFile($request)
    {

        $queryPendingTask = function ($query) {
            $query->select('id', 'vehicle_id', 'group_task_id', 'task_id', 'state_pending_task_id', 'datetime_start', 'datetime_finish', 'datetime_pending', 'observations')
                ->with(array(
                    'task' => function ($query) {
                        $query->select('id', 'sub_state_id', 'name')
                            ->with(array(
                                'subState' => function ($query) {
                                    $query->select('id', 'state_id', 'name', 'display_name')
                                        ->with(array(
                                            'state' => function ($query) {
                                                $query->select('id', 'name');
                                            }
                                        ));
                                }
                            ));
                    },
                    'statePendingTask' => function ($query) {
                        $query->select('id', 'name');
                    },
                    'incidences',
                    'budgetPendingTasks' => function ($query) {
                        $query->select('id', 'pending_task_id', 'state_budget_pending_task_id', 'url')
                            ->with(array(
                                'stateBudgetPendingTask' => function ($query) {
                                    $query->select('id', 'name');
                                }
                            ));
                    }
                ));
        };

        $query = Vehicle::select([
            'id',
            'plate',
            'kms',
            'vehicle_model_id',
            'sub_state_id',
            'campa_id',
            'category_id',
            'type_model_order_id',
            'trade_state_id'
        ])->with(array(
            'requests.customer',
            'reservations',
            'tradeState',
            'orders',
            'campa' => function ($query) {
                $query->select('id', 'name', 'location');
            },
            'category' => function ($query) {
                $query->select('id', 'name');
            },
            'typeModelOrder' => function ($query) {
                $query->select('id', 'name');
            },
            'damages' => function ($query) {
                $query->select('id', 'vehicle_id', 'damage_type_id', 'description', 'severity_damage_id', 'status_damage_id');
            },
            'lastReception' => function ($query) {
                $query->select('id', 'lastReception.vehicle_id', 'created_at')
                    ->with(array(
                        'vehiclePictures' => function ($query) {
                            $query->select('id', 'vehicle_id', 'reception_id', 'url', 'active');
                        }
                    ));
            },
            'lastQuestionnaire' => function ($query) {
                $query->select('id', 'lastQuestionnaire.vehicle_id', 'file')
                    ->with(array(
                        'questionAnswers' => function ($query) {
                            $query->select('id', 'questionnaire_id', 'task_id', 'response', 'question_id', 'description', 'description_response')
                                ->with(array(
                                    'question' => function ($query) {
                                        $query->select('id', 'question', 'description');
                                    },
                                    'task' => function ($query) {
                                        $query->select('id', 'sub_state_id', 'type_task_id', 'name');
                                    }
                                ));
                        }
                    ));
            },
            'square' => function ($query) {
                $query->select('vehicle_id', 'id', 'street_id', 'name')
                    ->with(array(
                        'street' => function ($query) {
                            $query->select('id', 'name', 'zone_id')
                                ->with(array(
                                    'zone' => function ($query) {
                                        $query->select('id', 'name');
                                    }
                                ));
                        }
                    ));
            },
            'vehicleModel' => function ($query) {
                $query->select('id', 'name', 'brand_id')
                    ->with(array(
                        'brand' => function ($query) {
                            $query->select('id', 'name');
                        }
                    ));
            },
            'subState' => function ($query) {
                $query->select('id', 'name', 'state_id', 'display_name')
                    ->with(array(
                        'state' => function ($query) {
                            $query->select('id', 'name');
                        }
                    ));
            },
            'lastGroupTask' => function ($query) use ($queryPendingTask) {
                $query->select('id', 'lastGroupTask.vehicle_id', 'approved', 'datetime_approved')
                    ->with(array(
                        //    'pendingTasks' => $queryPendingTask,
                        'approvedPendingTasks' => $queryPendingTask
                    ));
            }
        ))
            ->filter($request->all())
            ->selectRaw('(SELECT MAX(r.id) FROM receptions r WHERE r.vehicle_id = vehicles.id) as reception_id')
            ->orderBy('reception_id', 'desc');

        return ['vehicles' => $query->paginate($request->input('per_page') ?? 5)];
    }

    public function createFromExcel($request)
    {
        $vehicles = $request->input('vehicles');
        foreach ($vehicles as $vehicle) {
            $existVehicle = Vehicle::where('plate', $vehicle['plate'])
                ->first();
            if ($existVehicle) {
                $category = $this->categoryRepository->searchCategoryByName($vehicle['category']);
                if ($category) $existVehicle->category_id = $category['id'];
                $brand = $vehicle['brand'] ? $this->brandRepository->getByNameFromExcel($vehicle['brand']) : null;
                $vehicle_model = $brand ? $this->vehicleModelRepository->getByNameFromExcel($brand['id'], $vehicle['vehicle_model']) : null;
                $typeModelOrder = $vehicle['channel'] ? $this->typeModelOrderRepository->getByName($vehicle['channel']) : null;
                $existVehicle->vehicle_model_id = $vehicle_model ? $vehicle_model['id'] : null;
                $existVehicle->type_model_order_id = $typeModelOrder ? $typeModelOrder['id'] : null;
                $existVehicle->save();
            }
        }
        return ['message' => 'Vehicles created!'];
    }

    public function getByPlate($request)
    {
        return Vehicle::where('plate', $request->json()->get('plate'))
            ->first();
    }

    public function create($request)
    {
        $existVehicle = Vehicle::where('plate', $request->input('plate'))->withTrashed()
            ->first();
        if ($existVehicle) {
            return [
                'code' => is_null($existVehicle->deleted_at) ? 422 : 406,
                'vehicle' => $existVehicle
            ];
        }
        $vehicle = Vehicle::create($request->all());
        if (is_null($vehicle->company_id)) {
            $user = Auth::user();
            $vehicle->company_id = $user->company_id;
        }
        $vehicle->created_by = Auth::id();
        $vehicle->save();
        $this->newReception($vehicle->id);
        $this->stateChangeRepository->updateSubStateVehicle($vehicle);
        return $vehicle;
    }

    public function update($request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->all());
        return Vehicle::with($this->getWiths($request->with) ?? [])->findOrFail($id);
    }

    public function updateBack($request)
    {
        $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
        $vehicle->update($request->all());
        return response()->json(['vehicle' => $vehicle]);
    }

    public function updateCampa($vehicle_id, $campa)
    {
        $vehicle = Vehicle::findOrFail($vehicle_id);
        $vehicle->campa_id = $campa;
        $vehicle->save();
        return $vehicle;
    }

    public function updateTradeState($vehicle_id, $trade_state_id)
    {
        $vehicle = Vehicle::findOrFail($vehicle_id);
        $vehicle->trade_state_id = $trade_state_id;
        $vehicle->save();
        return response()->json(['vehicle' => $vehicle]);
    }

    public function verifyPlate($request)
    {
        $vehicle = Vehicle::with($this->getWiths($request->with))
        ->filter($request->all())
        ->first();;

        $vehicleDefleet = Vehicle::where('id', $vehicle?->id)
            ->byPendingRequestDefleet()
            ->first();

        $defleetingAndDelivery = Vehicle::where('id', $vehicle?->id)->filter(['defleetingAndDelivery' => 0])->first();

        if ($vehicleDefleet) {
            return ['vehicle' => $vehicle, 'defleet' => true, 'vehicle_delivery' => $defleetingAndDelivery];
        } else if ($vehicle) {
            return ['vehicle' => $vehicle, 'registered' => true, 'vehicle_delivery' => $defleetingAndDelivery];
        }
        return ['registered' => false];
    }

    public function verifyPlateReception($request)
    {

        $vehicle = Vehicle::with($this->getWiths($request->with))
            ->where('plate', $request->input('plate'))
            ->first();

        if ($vehicle) {
            $variables_defleet = $this->defleetVariableRepository->getVariablesByCompany($vehicle['campa']['company']['id']);
            $date_first_plate = new DateTime($vehicle->first_plate);
            $date = date("Y-m-d H:i:s");
            $today = new DateTime($date);
            $diff = $date_first_plate->diff($today);
            $year = $diff->format('%Y');
            if ($variables_defleet) {
                if (($vehicle->kms > $variables_defleet->kms || $year > $variables_defleet->years)) {
                    //Si el vehículo cumple con los kpis de defleet se cambia el estado a solicitado por defleet a espera de que lleven el vehículo a la zona pendiente de venta V.O.
                    $this->updateTradeState($vehicle->id, TradeState::REQUEST_DEFLEET);
                    return response()->json(['defleet' => true, 'message' => 'Vehículo para defletar'], 200);
                }
            }
            return response()->json(['vehicle' => $vehicle, 'registered' => true], 200);
        } else {
            return response()->json(['registered' => false], 200);
        }
    }

    public function vehicleDefleet($request)
    {
        $user = $this->userRepository->getById($request, Auth::id());
        $variables = $this->defleetVariableRepository->getVariablesByCompany($user->company_id);
        $date = date("Y-m-d");
        $date_defleet = date("Y-m-d", strtotime($date . " - $variables->years years")) . ' 00:00:00';
        return Vehicle::with($this->getWiths($request->with))
            ->noActiveOrPendingRequest()
            ->byParameterDefleet($date_defleet, $variables->kms)
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }

    public function delete($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->deleted_user_id = Auth::id();
        $this->squareRepository->freeSquare($vehicle->id);
        $vehicle->save();
        $vehicle->delete();
        return ['message' => 'Vehicle deleted'];
    }

    public function returnVehicle($request, $id)
    {
        $vehicle = Vehicle::where('id', $id)->withTrashed()->first();
        $vehicle->deleted_user_id = Auth::id();
        $vehicle->deleted_at = null;
        $vehicle->sub_state_id = null;
        $vehicle->update($request->all());
        $user = Auth::user();
        if (is_null($vehicle->campa_id)) {
            if (count($user->campas) > 0) {
                $vehicle->campa_id = $user->campas[0]->id;
            } else if ($vehicle->lastReception?->campa_d) {
                $vehicle->campa_id = $vehicle->lastReception?->campa_id;
            }
        }
        $vehicle->restore();
        $this->finishPendingTaskLastGroupTask($vehicle->id);
        $this->newReception($vehicle->id);
        return $vehicle;
    }

    public function newReception($vehicle_id, $group_task_id = null, $approved = true)
    {
        $user = $this->userRepository->getById([], Auth::id());
        $vehicle = Vehicle::find($vehicle_id);
        
        $vehicle_ids = collect(Vehicle::where('id', $vehicle->id)->filter(['defleetingAndDelivery' => 0])->get())->map(function ($item) {return $item->id;})->toArray();
        Log::debug($vehicle_ids);
        if (is_null($vehicle->lastReception) || $vehicle->sub_state_id === SubState::ALQUILADO || count($vehicle_ids) > 0) {
            $reception = new Reception();
        } else {
            $reception = $vehicle->lastReception;
        } 

        if (is_null($group_task_id)) {
            $group_task = $this->groupTaskRepository->create([
                'vehicle_id' => $vehicle_id,
                'approved_available' => $approved,
                'approved' => $approved
            ]);
            $group_task_id = $group_task->id;
        } else {
            if ($vehicle->lastGroupTask && count($vehicle->lastGroupTask->allApprovedPendingTasks) > 0) {
                $reception->created_at = $vehicle->lastGroupTask->allApprovedPendingTasks[0]->created_at;
                $reception->updated_at = $vehicle->lastGroupTask->allApprovedPendingTasks[0]->updated_at;
            }
        }

        $reception->group_task_id = $group_task_id;
        $reception->campa_id = $user->campas->pluck('id')->toArray()[0];;
        $reception->vehicle_id = $vehicle_id;
        $reception->finished = false;
        $reception->has_accessories = false;
        $reception->type_model_order_id = $vehicle->type_model_order_id;
        $reception->save();
        return $reception;
    }

    private function finishPendingTaskLastGroupTask($vehicleId)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
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
    }

    public function deleteMassive($request)
    {
        $plates = $request->get('plates');
        foreach ($plates as $plate) {
            Vehicle::where('plate', $plate)->delete();
        }
        return response()->json(['message' => 'Vehicles deleted!']);
    }


    public function getVehiclesWithReservationWithoutOrderCampa($request)
    {
        $vehicles = Vehicle::with($this->getWiths($request->with))
            ->thathasReservationWithoutOrderWithoutDelivery()
            ->filter($request->all())
            ->get();
        return ['vehicles' => $vehicles];
    }

    public function getVehiclesWithReservationWithoutContractCampa($request)
    {
        $vehicles = Vehicle::with($this->getWiths($request->with))
            ->byWithOrderWithoutContract()
            ->filter($request->all())
            ->get();
        return ['vehicles' => $vehicles];
    }

    public function vehicleReserved($request)
    {
        $user = $this->userRepository->getById($request, Auth::id());
        return Vehicle::with(['reservations' => fn ($query) => $query->where('active', true)])
            ->whereHas('reservations', fn (Builder $builder) => $builder->where('active', true))
            ->byCampasOfUser($user->campas->pluck('id')->toArray())
            ->get();
    }

    public function vehicleTotalsState($request)
    {
        return Vehicle::with($this->getWiths($request->with))
            ->filter($request->all())
            ->select(DB::raw('sub_state_id, COUNT(*) AS count'))
            ->groupBy('sub_state_id')
            ->get();
    }

    public function vehicleRequestDefleet($request)
    {
        $user = $this->userRepository->getById($request, Auth::id());
        $vehicles = Vehicle::with($this->getWiths($request->with))
            ->withRequestDefleetActive()
            ->where('trade_state_id', TradeState::REQUEST_DEFLEET)
            ->where('sub_state_id', '<>', SubState::SOLICITUD_DEFLEET)
            ->byCampasOfUser($user->campas->pluck('id')->toArray())
            ->get();
        return ['vehicles' => $vehicles];
    }

    public function vehiclesByState($request)
    {
        return Vehicle::with($this->getWiths($request->with))
            ->stateIds($request->input('states'))
            ->defleetBetweenDateApproved($request->input('date_start'), $request->input('date_end'))
            ->campasIds($request->input('campas'))
            ->get();
    }

    public function changeSubState($request)
    {
        $vehicles = $request->input('vehicles');
        $deliveryNote = $this->deliveryNoteRepository->create($request->input('data'), $request->input('type_delivery_note_id'));
        Vehicle::whereIn('id', collect($vehicles)->pluck('id')->toArray())
            ->chunk(200, function ($vehicles) use ($request, $deliveryNote) {
                foreach ($vehicles as $vehicle) {
                    if ($request->input('sub_state_id') == SubState::ALQUILADO) {
                        $this->closeDamage($vehicle['id']);
                        $count = 0;
                        if (!is_null($vehicle->lastGroupTask)) {
                            foreach ($vehicle->lastGroupTask->pendingTasks as $key => $pending_task) {
                                $count++;
                                $pending_task->state_pending_task_id = StatePendingTask::FINISHED;
                                $pending_task->order = -1;
                                if (is_null($pending_task->datetime_pending)) {
                                    $pending_task->datetime_pending = Carbon::now()->addSeconds($count * 1);
                                }
                                if (is_null($pending_task->datetime_start)) {
                                    $pending_task->datetime_start = Carbon::now()->addSeconds($count * 2);
                                }
                                if (is_null($pending_task->datetime_finish)) {
                                    $pending_task->datetime_finish = Carbon::now()->addSeconds($count * 3);
                                }
                                if (is_null($pending_task->user_start_id)) {
                                    $pending_task->user_start_id = Auth::id();
                                }
                                if (is_null($pending_task->user_end_id)) {
                                    $pending_task->user_end_id = Auth::id();
                                }
                                $pending_task->save();
                                $reception = $pending_task->reception;
                                if (!is_null($reception)) {
                                    $reception->finished = 1;
                                    $reception->save();
                                }
                            }
                        }
                        $hasLastGroupTask = $vehicle->lastReception?->groupTask?->id ?? null;
                        if (!$hasLastGroupTask) {
                            $reception = $this->newReception($vehicle->id);
                            $hasLastGroupTask = $reception->groupTask->id;
                        }
                        $this->deliveryVehicleRepository->createDeliveryVehicles($vehicle['id'], $request->input('data'), $deliveryNote->id, $count + 1, $hasLastGroupTask);
                        $reception = $vehicle->lastReception;
                        if ($reception) {
                            $reception->finished = true;
                            $reception->save();
                        }
                        if ($vehicle->sub_state_id != SubState::SOLICITUD_DEFLEET) {
                            $vehicle->sub_state_id = null;
                        }
                        $vehicle->save();
                        $this->stateChangeRepository->updateSubStateVehicle($vehicle, SubState::ALQUILADO);
                    }
                    if ($request->input('sub_state_id') == SubState::WORKSHOP_EXTERNAL || $request->input('sub_state_id') == SubState::TRANSIT) {
                        $this->vehicleExitRepository->registerExit($vehicle['id'], $deliveryNote->id, $vehicle->campa_id);
                        $vehicle->sub_state_id = $request->input('sub_state_id');
                        $vehicle->save();
                    }
                    $this->freeSquare($vehicle);
                }
            });
        return [
            'delivery_note' => $deliveryNote
        ];
    }

    private function freeSquare($vehicle)
    {
        $square = $vehicle->square()->first();
        if (!is_null($square)) {
            $this->historyLocationRepository->saveFromBack($square->vehicle_id, null, Auth::id());
            $square->vehicle_id = null;
            $square->save();
        }
    }

    public function setVehicleRented($request)
    {
        $vehicles = $request->input('vehicles');
        foreach ($vehicles as $vehicle) {
            $updateVehicle = Vehicle::where('plate', $vehicle)
                ->first();
            if ($updateVehicle) {
                $updateVehicle->sub_state_id = SubState::ALQUILADO;
                $updateVehicle->save();
            }
        }

        return response()->json(['message' => 'Done!']);
    }

    public function setSubStateNull($request)
    {
        $plates = $request->get('plates');
        foreach ($plates as $plate) {
            $vehicle = Vehicle::where('plate', $plate)->first();
            if ($vehicle) {
                $vehicle->sub_state_id = null;
                $vehicle->save();
                $this->deletePendingTasks($vehicle->id);
            }
        }
    }

    private function deletePendingTasks($vehicleId)
    {
        PendingTask::where('vehicle_id', $vehicleId)
            ->where('approved', true)
            ->where(function ($query) {
                return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                    ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS)
                    ->orWhereNull('state_pending_task_id');
            })
            ->chunk(200, function ($pendingTasks) {
                foreach ($pendingTasks as $pendingTask) {
                    $pendingTask->update(['approved' => false]);
                }
            });
    }

    public function defleet($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->sub_state_id = SubState::SOLICITUD_DEFLEET;
        // $vehicle->type_model_order_id = TypeModelOrder::VO;
        $vehicle->save();
        if ($vehicle->lastUnapprovedGroupTask) {
            $this->groupTaskRepository->disablePendingTasks($vehicle->lastUnapprovedGroupTask);
        }
        return $vehicle;
    }

    public function unDefleet($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->sub_state_id = SubState::CHECK;
        $vehicle->save();
        if ($vehicle->lastGroupTask) {
            $this->groupTaskRepository->enablePendingTasks($vehicle->lastGroupTask);
        }
        return response()->json([
            'message' => 'Vehicle defleeted!'
        ]);
    }

    private function closeDamage($vehicleId)
    {
        Damage::where('vehicle_id', $vehicleId)
            ->where('status_damage_id', '!=', StatusDamage::CLOSED)
            ->chunk(200, function ($damages) {
                foreach ($damages as $damage) {
                    $damage->update([
                        'status_damage_id' => StatusDamage::CLOSED,
                        'datetime_close' => Carbon::now()
                    ]);
                }
            });
    }

    public function pendingOrInProgress($vehicleId)
    {
        return Vehicle::where('id', $vehicleId)
            ->with(['lastGroupTask.pendingTasks' => function ($builder) {
                return $builder->where('state_pending_task_id', StatePendingTask::PENDING)
                    ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS);
            }])
            ->first();
    }

    // GroupTasks of last reception
    public function lastGroupTasks($request)
    {
        $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
        if ($vehicle->lastReception?->group_task_id < $vehicle->lastGroupTask?->id) {
            $value = [
                'fix' => 'ESTA RECEPCION ESTA EN UN GRUPO ANTERIOR',
                'last_reception_group_id' => $vehicle->lastReception?->group_task_id,
                'last_group_id' => $vehicle->lastGroupTask?->id,
                'count_reception_approved_pending_tasks' => count($vehicle->lastReception?->groupTask?->approvedPendingTasks ?? []),
                'count_last_group_task_approved_pending_tasks' => count($vehicle->lastGroupTask?->approvedPendingTasks ?? [])
            ];
            if ($value['count_reception_approved_pending_tasks'] === 0) {
                $this->newReception($vehicle->id, $vehicle->lastGroupTask?->id);
                $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
            }
        }
        return Vehicle::with(array_merge($this->getWiths($request->with), ['allApprovedPendingTasks' => function ($query) use ($vehicle) {
            return $query
                ->where('group_task_id', '=', $vehicle->lastReception?->group_task_id)
                // ->where('created_at', '>=', $vehicle->lastReception->created_at ?? Carbon::now())
                ->orderBy('id', 'desc')
                ->orderBy('created_at', 'desc');
        }]))
            ->filter($request->all())
            ->findOrFail($request->input('vehicle_id'));
    }
}
