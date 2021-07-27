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
        "campa_id",
        'category_id',
        'sub_state_id',
        'ubication',
        'plate',
        'vehicle_model_id',
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

    public function requests(){
        return $this->hasMany(Request::class, 'vehicle_id');
    }

    public function pending_tasks(){
        return $this->hasMany(PendingTask::class, 'vehicle_id');
    }

    public function group_tasks(){
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

    public function tradeState(){
        return $this->belongsTo(TradeState::class, 'trade_state_id');
    }

    public function questionnaires(){
        return $this->hasMany(Questionnaire::class);
    }

    public function lastQuestionnaire(){
        return $this->hasOne(Questionnaire::class)->with(['questionAnswers.question','questionAnswers.task'])->ofMany([
            'id' => 'max'
        ]);
    }

    public function scopeByCampasOfUser($query){
        $userRepository = new UserRepository();
        $user = $userRepository->getById(Auth::id());
        return $query->whereIn('campa_id', $user->campas->pluck('id')->toArray());
    }

    public function scopeByCampaId($id){
        return $this->where('campa_id', $id);
    }

    public function vehicleModel(){
        return $this->belongsTo(VehicleModel::class);
    }

    public function scopeCampasIds($query, $ids){
        return $query->whereIn('campa_id', $ids);
    }

    public function scopeSubStateIds($query, $ids){
        return $query->whereIn('sub_state_id', $ids);
    }

    public function scopeStateIds($query, $ids){
        return $query->whereHas('subState', function (Builder $builder) use ($ids) {
            return $builder->whereIn('state_id', $ids);
        });
    }

    public function scopeByPlate($query, $plate){
        return $query->where('plate','like',"%" . $plate . "%");
    }

    public function scopeByTradeStateIds($query, $ids){
        return $query->whereIn('trade_state_id', $ids);
    }

    public function scopeBrandIds($query, $ids){
        return $query->whereHas('vehicleModel', function (Builder $builder) use($ids) {
            return $builder->whereIn('brand_id', $ids);
        });
    }

    public function scopeVehicleModelIds($query, $ids){
        return $query->whereIn('vehicle_model_id', $ids);
    }

    public function scopeCategoriesIds($query, $ids){
        return $query->whereIn('category_id',$ids);
    }

    public function scopeByUbication($query, $ubication){
        return $query->where('ubication','LIKE', "%$ubication%");
    }

    public function scopeByReadyDelivery($query, $value){
        return $query->where('ready_to_delivery', $value);
    }

    public function lastUnapprovedGroupTask(){
        return $this->hasOne(GroupTask::class)->ofMany([
            'id' => 'max'
        ], function ($query) {
            $query->where('approved', false)
                 ->where('approved_available', false);
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

    public function withoutOrderWithoutDelivery($query){
        return $query->where(function ($query) {
            return $query->whereNull('order');
        })
        ->orWhere(function ($query) {
            return $query->whereNotNull('order')
                ->whereNull('pickup_by_customer')
                ->whereNull('transport_id');
        })
        ->where('active', true);
    }

    public function withRequestActive(){
        return $this->hasMany(Request::class)
        ->where('state_request_id', StateRequest::REQUESTED);
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

    public function withOrderWithoutContract($query){
        return $query->whereNotNull('order')
            ->whereNull('contract')
            ->where('active', true)
            ->where(function($query) {
                return $query->whereNotNull('pickup_by_customer')
                            ->orWhereNotNull('transport_id');
            });
    }

    public function scopeWithOrderWithoutContract($query){
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
        return $query->whereHas('subState.state', fn (Builder $builder) => $builder->where('id','<>', State::PENDING_SALE_VO));
    }

    public function scopeDefleetBetweenDateApproved(Builder $builder, $dateStart, $dateEnd){
        return $builder->whereHas('requests', function($query) use($dateStart, $dateEnd){
            return $query->where('type_request_id', TypeRequest::DEFLEET)
                ->whereDate('datetime_approved', '>=', $dateStart)
                ->whereDate('datetime_approved', '<=', $dateEnd);
        });
    }
}
