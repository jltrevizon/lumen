<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campa;
use App\Models\Category;
use App\Models\State;
use App\Models\DeliveryVehicle;
use App\Models\Request;
use App\Models\PendingTask;
use App\Models\GroupTask;
use App\Models\VehiclePicture;
use App\Models\Reservation;
use App\Models\Reception;
use App\Models\TradeState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{

    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'remote_id',
        'company_id',
        "campa_id",
        'category_id',
        'sub_state_id',
        'color_id',
        'ubication',
        'plate',
        'vehicle_model_id',
        'color',
        'type_model_order_id',
        'kms',
        'last_change_state',
        'next_itv',
        'has_environment_label',
        'observations',
        'priority',
        'version',
        'vin',
        'first_plate',
        'latitude',
        'longitude',
        'trade_state_id',
        'documentation',
        'ready_to_delivery',
        'deleted_user_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function campa(){
        return $this->belongsTo(Campa::class, 'campa_id');
    }

    public function subState(){
        return $this->belongsTo(SubState::class);
    }

    public function color(){
        return $this->belongsTo(Color::class);
    }

    public function requests(){
        return $this->hasMany(Request::class, 'vehicle_id');
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function pendingTasks(){
        return $this->hasMany(PendingTask::class, 'vehicle_id');
    }

    public function pendingTasksBudget(){
        return $this->hasMany(PendingTask::class, 'vehicle_id')
            ->where('approved', true)
            ->where(function($query){
                return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                    ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS);
            })->whereHas('budgetPendingTasks');
    }

    public function groupTasks(){
        return $this->hasMany(GroupTask::class, 'vehicle_id');
    }

    public function vehiclePictures(){
        return $this->hasMany(VehiclePicture::class, 'vehicle_id');
    }

    public function reservations(){
        return $this->hasMany(Reservation::class, 'vehicle_id');
    }

    public function receptions(){
        return $this->hasMany(Reception::class, 'vehicle_id');
    }

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class);
    }

    public function tradeState(){
        return $this->belongsTo(TradeState::class, 'trade_state_id');
    }

    public function questionnaires(){
        return $this->hasMany(Questionnaire::class);
    }

    public function vehicleExits(){
        return $this->hasMany(VehicleExit::class);
    }

    public function operations(){
        return $this->hasMany(Operation::class);
    }

    public function incidences(){
        return $this->hasMany(Incidence::class);
    }

    public function damages(){
        return $this->hasMany(Damage::class);
    }

    public function accessories(){
        return $this->belongsToMany(Accessory::class)->withTimestamps();
    }

    public function accessoriesTypeAccessory(){
        return $this->belongsToMany(Accessory::class)
            ->where('accessory_type_id', Accessory::ACCESSORY);
    }

    public function pendingAuthorizations(){
        return $this->hasMany(PendingAuthorization::class);
    }

    public function lastQuestionnaire(){
        return $this->hasOne(Questionnaire::class)->with(['questionAnswers.question','questionAnswers.task'])->ofMany([
            'id' => 'max'
        ]);
    }

    public function lastReception(){
        return $this->hasOne(Reception::class)->with(['vehiclePictures'])->ofMany([
            'id' => 'max'
        ]);
    }


    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function lastOrder(){
        return $this->hasOne(Order::class)->ofMany([
            'id' => 'max'
        ]);
    }

    public function budgets(){
        return $this->hasMany(Budget::class);
    }

    public function deliveryVehicles(){
        return $this->hasMany(DeliveryVehicle::class);
    }

    public function lastDeliveryVehicle(){
        return $this->hasOne(DeliveryVehicle::class)->ofMany([
            'id' => 'max'
        ]);
    }

    public function scopeByIds($query, $ids){
        return $query->whereIn('id', $ids);
    }

    public function vehicleModel(){
        return $this->belongsTo(VehicleModel::class);
    }

    public function subStateChangeHistories(){
        return $this->hasMany(SubStateChangeHistory::class);
    }

    public function stateChange(){
        return $this->hasMany(StateChange::class);
    }

    public function lastStateChange(){
        return $this->hasOne(StateChange::class)->ofMany([
            'id' => 'max'
        ]);
    }

    public function square(){
        return $this->hasOne(Square::class);
    }

    public function scopeByRole($query, $roleId){
        if ($roleId == Role::MANAGER_MECHANIC) {
            return $this->mechanic($query);
        }

        if ($roleId == Role::MANAGER_CHAPA) {
            return $this->chapa($query);
        }
    }

    private function mechanic($query){
        return $query->with(['vehicleModel.brand','lastGroupTask.approvedPendingTasks.task.subState','lastGroupTask.approvedPendingTasks.incidences','lastGroupTask.approvedPendingTasks.vehicle.vehicleModel.brand',
            'lastGroupTask.approvedPendingTasks.budgetPendingTasks.stateBudgetPendingTask','lastReception','campa','category','subState.state','tradeState','reservations',
            'requests.customer','lastGroupTask.pendingTasks.budgetPendingTasks','lastGroupTask.pendingTasks.incidences','lastGroupTask.pendingTasks.task','lastGroupTask.pendingTasks.statePendingTask','typeModelOrder','lastGroupTask.approvedPendingTasks.statePendingTask',
            'lastGroupTask.approvedPendingTasks' => function ($query) {
                return $query->where(function($query){
                    return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                        ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS);
                })
                ->whereHas('task.subState', function($query){
                    return $query->where('state_id', State::WORKSHOP);
                });
            }
        ])
        ->whereHas('pendingTasks', function(Builder $builder){
            return $builder->where('approved', true)
                ->where(function($query){
                    $query->where('state_pending_task_id', StatePendingTask::PENDING)
                        ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS);
                })
                ->whereHas('task.subState', function(Builder $builder){
                    return $builder->where('state_id', State::WORKSHOP);
                });
        });
    }

    private function chapa($query){
        return $query->with(['vehicleModel.brand','lastGroupTask.approvedPendingTasks.task.subState','lastGroupTask.approvedPendingTasks.incidences','lastGroupTask.approvedPendingTasks.vehicle.vehicleModel.brand',
        'lastGroupTask.approvedPendingTasks.budgetPendingTasks.stateBudgetPendingTask','lastReception','campa','category','subState.state','tradeState','reservations',
        'requests.customer','lastGroupTask.pendingTasks.budgetPendingTasks','lastGroupTask.pendingTasks.incidences','lastGroupTask.pendingTasks.task','lastGroupTask.pendingTasks.statePendingTask','typeModelOrder','lastGroupTask.approvedPendingTasks.statePendingTask',
        'lastGroupTask.approvedPendingTasks' => function ($query) {
                return $query->where(function($query){
                    return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                        ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS)
                        ->orWhereNull('state_pending_task_id');
                })
                ->whereHas('task', function($query){
                    return $query->where('sub_state_id', SubState::CHAPA)
                        ->orWhere('sub_state_id', SubState::MECANICA);
                });
            }
        ])
        ->whereHas('pendingTasks', function(Builder $builder){
            return $builder->where('approved', true)
                ->where(function($query){
                    $query->where('state_pending_task_id', StatePendingTask::PENDING)
                        ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS)
                        ->orWhereNull('state_pending_task_id');
                })
                ->whereHas('task', function(Builder $builder){
                    return $builder->where('sub_state_id', SubState::CHAPA);
                });
        });
    }

    public function scopeByWhereHasBudgetPendingTask($query){
        return $query->whereHas('pendingTasks.budgetPendingTasks');
    }

    public function scopeByCampasOfUser($query, array $campasIds){
        return $query->whereIn('campa_id', $campasIds);
    }

    public function scopeByCampaNull($query){
        return $query->whereNull('campa_id');
    }

    public function scopeBySubStateNull($query){
        return $query->whereNull('sub_state_id');
    }

    public function scopeByCampaId($query, int $id){
        return $query->where('campa_id', $id);
    }

    public function scopeCampasIds($query, array $ids){
        return $query->whereIn('campa_id', $ids);
    }

    public function scopeSubStateIds($query, array $ids){
        return $query->whereIn('sub_state_id', $ids);
    }

    public function scopeStateIds($query, array $ids){
        return $query->whereHas('subState', function (Builder $builder) use ($ids) {
            return $builder->whereIn('state_id', $ids);
        });
    }

    public function scopeByCompanies($query, array $ids){
        return $query->whereIn('company_id', $ids);
    }

    public function scopeByPlate($query, string $plate){
        return $query->where('plate','like',"%" . $plate . "%");
    }

    public function scopeByTradeStateIds($query, array $ids){
        return $query->whereIn('trade_state_id', $ids);
    }

    public function scopeBrandIds($query, array $ids){
        return $query->whereHas('vehicleModel', function (Builder $builder) use($ids) {
            return $builder->whereIn('brand_id', $ids);
        });
    }

    public function scopeByTypeModelOrderIds($query, array $ids){
        return $query->whereIn('type_model_order_id', $ids);
    }

    public function scopeByBudgetPendingTaskIds($query, array $ids){
        return $query->whereHas('pendingTasks', function(Builder $builder) use($ids){
            return $builder->whereHas('budgetPendingTasks', function ($query) use ($ids){
                return $query->whereIn('state_budget_pending_task_id', $ids);
            })
            ->where('approved', true);
        });
    }

    public function scopeVehicleModelIds($query, array $ids){
        return $query->whereIn('vehicle_model_id', $ids);
    }

    public function scopeCategoriesIds($query, array $ids){
        return $query->whereIn('category_id',$ids);
    }

    public function scopeByUbication($query, string $ubication){
        return $query->where('ubication','LIKE', "%$ubication%");
    }

    public function scopeByReadyDelivery($query, $value){
        return $query->where('ready_to_delivery', $value);
    }

    public function scopeByStatePendingTasks($query, array $ids){
        return $query->whereHas('lastGroupTask.approvedPendingTasks.task.subState', function (Builder $builder) use($ids) {
            return $builder->whereIn('state_id', $ids);
        });
    }

    public function scopeBySubStatePendingTasks($query, array $ids){
        return $query->whereHas('lastGroupTask.approvedPendingTasks.task', function (Builder $builder) use($ids) {
            return $builder->whereIn('sub_state_id', $ids);
        });
    }

    public function lastGroupTask(){
        return $this->hasOne(GroupTask::class)->ofMany([
            'id' => 'max'
        ]);
    }

    public function lastOrders(){
        return $this->hasOne(Order::class)->ofMany([
            'id' => 'max'
        ]);
    }

    public function lastUnapprovedGroupTask(){
        return $this->hasOne(GroupTask::class)->ofMany([
            'id' => 'max'
        ], function ($query) {
            $query->where('approved', false)
                 ->where('approved_available', false);
        });
    }

    public function scopeByHasGroupTaskUnapproved($query, $value){
        return $query->whereHas('groupTasks', function(Builder $builder) {
            return $builder->where('approved', false)
                ->where('approved_available', false);
        });
    }

    public function scopeByHasOrderNotFinish($query, $value){
        return $query->whereHas('orders', function (Builder $builder) {
            return $builder->where('state_id','!=', State::FINISHED);
        });
    }

    public function scopeByHasOrdersStateIds($query, $value){
         return $query->whereHas('orders', function (Builder $builder)  use ($value){
            return $builder->whereIn('state_id', $value);
        });
    }

    public function scopeNoActiveOrPendingRequest($query){
        return $query->whereHas('requests', function(Builder $builder) {
            return $builder->where('state_request_id', StateRequest::DECLINED);
        })
        ->orWhereDoesntHave('requests');
    }

    public function scopeByParameterDefleet($query, $dateDefleet, $kms){
        return $query->where('first_plate','<', $dateDefleet)
                    ->orWhere('kms','>', $kms);
    }

    public function scopeByPendingRequestDefleet($query){
        return $query->whereHas('requests', function(Builder $builder){
            return $builder->where('type_request_id', TypeRequest::DEFLEET)
                ->where(function($query) {
                    return $query->where('state_request_id', StateRequest::REQUESTED)
                        ->orWhere('state_request_id', StateRequest::APPROVED);
                });
        });
    }

    public function scopeThathasReservationWithoutOrderWithoutDelivery($query){
        return $query->whereHas('reservations', function (Builder $builder) {
            return $builder->where(function ($query) {
                return $query->whereNull('order');
            })
            ->orWhere(function ($query) {
                return $query->whereNotNull('order')
                    ->whereNull('pickup_by_customer')
                    ->whereNull('transport_id');
            })
            ->where('active', true);
        });
    }

    public function withRequestActive(){
        return $this->hasMany(Request::class)
        ->where('state_request_id', StateRequest::REQUESTED);
    }

    public function scopeByWithOrderWithoutContract($query){
        return $query->whereHas('reservations', function(Builder $builder) {
            return $builder->whereNotNull('order')
                ->whereNull('contract')
                ->where('active', true)
                ->where(function($query) {
                    return $query->whereNotNull('pickup_by_customer')
                                ->orWhereNotNull('transport_id');
                });
        });
    }

    public function scopeWithRequestDefleetActive($query){
        return $query->whereHas('requests', function (Builder $builder) {
            return $builder->where('type_request_id', TypeRequest::DEFLEET)
                    ->where('state_request_id', StateRequest::REQUESTED);
        });
    }

    public function scopeDifferentDefleeted($query){
        return $query->whereHas('subState.state', function (Builder $builder) {
            return $builder->where('id','!=', State::PENDING_SALE_VO);
        });
    }

    public function scopeDefleetBetweenDateApproved(Builder $builder, $dateStart, $dateEnd){
        return $builder->whereHas('requests', function($query) use($dateStart, $dateEnd){
            return $query->where('type_request_id', TypeRequest::DEFLEET)
                ->whereDate('datetime_approved', '>=', $dateStart)
                ->whereDate('datetime_approved', '<=', $dateEnd);
        });
    }

    public function withPendingTaskOrProgress(){
        return $this->hasMany(PendingTask::class)
            ->where(function($query){
                return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                    ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS);
            })->orderBy('order');
    }

    public function withLastPendingTaskOrProgress(){
        return $this->hasOne(PendingTask::class)
            ->where(function($query){
                return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                    ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS);
            })->ofMany([
            'order' => 'min'
        ]);
    }


    public function scopeByTaskSubStatesIds($query, $ids){
        return $query->whereHas('lastGroupTask.approvedPendingTasks.task', function(Builder $builder) use ($ids){
            return $builder->whereIn('sub_state_id', $ids);
        });
    }

    public function scopeByTaskStatesIds($query, $ids){
        return $query->whereHas('lastGroupTask.approvedPendingTasks.task.subState', function(Builder $builder) use ($ids){
            return $builder->whereIn('state_id', $ids);
        });

    }

    public function scopeByTaskIds($query, $ids){
        return $query->whereHas('lastGroupTask.approvedPendingTasks', function(Builder $builder) use ($ids){
            return $builder->whereIn('task_id', $ids);
        });
    }
}
