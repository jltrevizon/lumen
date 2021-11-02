<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campa;
use App\Models\Category;
use App\Models\State;
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
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class Vehicle extends Model
{

    use HasFactory, Filterable;

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
        'priority',
        'version',
        'vin',
        'first_plate',
        'latitude',
        'longitude',
        'trade_state_id',
        'documentation',
        'ready_to_delivery'
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

    public function accessories(){
        return $this->belongsToMany(Accessory::class);
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

    public function scopeByIds($query, $ids){
        return $query->whereIn('id', $ids);
    }

    public function vehicleModel(){
        return $this->belongsTo(VehicleModel::class);
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
        return $query->with(['vehicleModel.brand','lastGroupTask.pendingTasks.task.subState','lastGroupTask.pendingTasks.incidences','lastGroupTask.pendingTasks.vehicle.vehicleModel.brand',
            'lastGroupTask.pendingTasks.budgetPendingTasks.stateBudgetPendingTask','lastReception','campa','category','subState.state','tradeState','reservations',
            'requests.customer','lastGroupTask.pendingTasks.budgetPendingTasks','lastGroupTask.pendingTasks.statePendingTask',
            'lastGroupTask.pendingTasks' => function ($query) {
                return $query->where(function($query){
                    return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                        ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS)
                        ->orWhereNull('state_pending_task_id');
                })
                ->whereHas('task', function($query){
                    return $query->where('sub_state_id', SubState::MECANICA);
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
                    return $builder->where('sub_state_id', SubState::MECANICA);
                });
        });
    }

    private function chapa($query){
        return $query->with(['vehicleModel.brand','lastGroupTask.pendingTasks.task.subState','lastGroupTask.pendingTasks.incidences','lastGroupTask.pendingTasks.vehicle.vehicleModel.brand',
        'lastGroupTask.pendingTasks.budgetPendingTasks.stateBudgetPendingTask','lastReception','campa','category','subState.state','tradeState','reservations',
        'requests.customer','lastGroupTask.pendingTasks.budgetPendingTasks','lastGroupTask.pendingTasks.statePendingTask',
        'lastGroupTask.pendingTasks' => function ($query) {
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
        return $query->whereHas('pendingtasks.budgetPendingTasks');
    }

    public function scopeByCampasOfUser($query, array $campasIds){
        return $query->whereIn('campa_id', $campasIds);
    }

    public function scopeByCampaNull($query){
        return $query->whereNull('campa_id');
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
        return $query->whereHas('pendingTasks', function (Builder $builder) use($ids) {
            return $builder->whereIn('state_pending_task_id', $ids);
        })
        ->whereHas('lastGroupTask');
    }

    public function lastGroupTask(){
        return $this->hasOne(GroupTask::class)->ofMany([
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
        return $query->whereHas('subState.state', fn (Builder $builder) => $builder->where('id','!=', State::PENDING_SALE_VO));
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
            });
    }
}
