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

class Vehicle extends Model
{
    protected $fillable = [
        'remote_id',
        "campa_id",
        'category_id',
        'state_id',
        'ubication',
        'plate',
        'branch',
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

    public function vehicle_pictures(){
        return $this->hasMany(VehiclePicture::class, 'vehicle_id');
    }

    public function reservations(){
        return $this->hasMany(Reservation::class, 'vehicle_id');
    }

    public function receptions(){
        return $this->hasMany(Reception::class, 'vehicle_id');
    }

    public function trade_state(){
        return $this->belongsTo(TradeState::class, 'trade_state_id');
    }

    public function questionnaires(){
        return $this->hasMany(Questionnaire::class);
    }

    public function lastQuestionnaire(){
        return $this->hasOne(Questionnaire::class)->with(['questionAnswers.question'])->ofMany([
            'id' => 'max'
        ]);
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

    public function scopePlate($query, $plate){
        return $query->where('plate','like',"%$plate%");
    }

    public function scopeBrandIds($query, $ids){
        return $query->whereHas('vehicleModel', function (Builder $builder) use($ids) {
            return $builder->whereIn('brand_id', $ids);
        });
    }

    public function scopeCategoriesIds($query, $ids){
        return $query->whereIn('category_id',$ids);
    }

    public function lastUnapprovedGroupTask(){
        return $this->hasOne(GroupTask::class)->ofMany([
            'id' => 'max'
        ], function ($query) {
            $query->where('approved', false);
        });
    }
}
