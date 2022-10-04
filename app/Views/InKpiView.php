<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;
use App\Models\TypeModelOrder;
use App\Models\PendingTask;
use Illuminate\Support\Facades\DB;

class InKpiView extends Model
{
    use Filterable;
    protected $table = 'view_in_kpis';

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class);
    }

    public function defleetingAndDelivery($value) {
        $vehicle_ids = collect(
            PendingTask::where('state_pending_task_id', 3)
            ->where('task_id', 38)
            ->whereRaw(Db::raw('reception_id = (Select max(r.id) from receptions r where r.vehicle_id = pending_tasks.vehicle_id)'))
            ->whereRaw(DB::raw('vehicle_id in (SELECT v.id from vehicles v where v.sub_state_id = 8)'))->get('vehicle_id'))
            ->map(function ($item){ return $item->vehicle_id;})->toArray();
        if ($value) {
            return $this->whereNotIn('vehicle_id', $vehicle_ids);
        }
        return $this->whereIn('vehicle_id', $vehicle_ids);
    }
}
