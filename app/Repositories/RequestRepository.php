<?php

namespace App\Repositories;
use App\Models\Request as RequestVehicle;
use App\Models\State;
use App\Models\StateRequest;
use App\Models\SubState;
use App\Models\TradeState;
use App\Models\TypeRequest;
use App\Models\TypeReservation;
use App\Repositories\TaskReservationRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\PendingTaskRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class RequestRepository extends Repository {

    public function __construct(
        TaskReservationRepository $taskReservationRepository,
        PendingTaskRepository $pendingTaskRepository,
        ReservationRepository $reservationRepository,
        UserRepository $userRepository,
        VehicleRepository $vehicleRepository)
    {
        $this->taskReservationRepository = $taskReservationRepository;
        $this->pendingTaskRepository = $pendingTaskRepository;
        $this->reservationRepository = $reservationRepository;
        $this->userRepository = $userRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function getById($id){
        return RequestVehicle::findOrFail($id);
    }

}
