<?php

namespace App\Http\Controllers;

use App\Exports\KpiCheckListExport;
use App\Exports\KpiDiffTimeReceptionExport;
use App\Exports\KpiFullExport;
use Illuminate\Http\Request;
use App\Exports\KpiInpuOutExport;
use App\Exports\PendingTaskExport as ExportsPendingTaskExport;
use App\Exports\KpiPendingTaskExport;
use App\Exports\KpiSubStateExport;
use App\Exports\KpiSubStateMonthExport;
use App\Exports\StockVehiclesExport;
use App\Models\Company;
use App\Models\DeliveryVehicle;
use App\Models\PendingTask;
use App\Models\Vehicle;
use App\Models\Reception;
use App\Models\StatePendingTask;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class KpiController extends Controller
{
    public function index(Request $request)
    {
    }

    public function inpu(Request $request)
    {
        $in_data = Reception::with(['typeModelOrder'])->filter(array_merge($this->request->all(), ['whereHasVehicle' => 0]))
            ->selectRaw('vehicles.type_model_order_id,COUNT(receptions.vehicle_id) as total, MONTH(receptions.created_at) as in_month, YEAR(receptions.created_at) as year')
            ->join('vehicles', 'vehicles.id', '=', 'receptions.vehicle_id')
            ->groupBy('vehicles.type_model_order_id', 'year', 'in_month')
            ->orderBy('year')
            ->orderBy('in_month')
            ->get();

        return $this->getDataResponse($in_data, HttpFoundationResponse::HTTP_OK);
    }

    public function out(Request $request)
    {

        $out_data = DeliveryVehicle::with(['typeModelOrder'])->filter(array_merge($this->request->all(), ['whereHasVehicle' => 1]))
            ->selectRaw('vehicles.type_model_order_id,COUNT(delivery_vehicles.vehicle_id) as total, MONTH(delivery_vehicles.created_at) as out_month, YEAR(delivery_vehicles.created_at) as year')
            ->join('vehicles', 'vehicles.id', '=', 'delivery_vehicles.vehicle_id')
            ->groupBy('vehicles.type_model_order_id', 'year', 'out_month')
            ->orderBy('year')
            ->orderBy('out_month')
            ->get();
        return $this->getDataResponse($out_data, HttpFoundationResponse::HTTP_OK);
    }

    public function subStates(Request $request)
    {
        ob_clean();
        return Excel::download(new KpiSubStateExport($request), 'Kpi_Sub-Estados-' . date('Y-m-d') . '.xlsx');
    }

    public function subStatesMonth(Request $request)
    {
        $data = Vehicle::filter($request->all())
            ->select(
                DB::raw('AVG(count) as `total`'),
                DB::raw('(SELECT v.id FROM vehicles v where v.id = vehicles.id) as count'),
                DB::raw('type_model_order_id'),
                DB::raw('sub_state_id'),
                DB::raw('YEAR(created_at) year'),
                DB::raw('MONTH(created_at) month'),
                DB::raw('DAY(created_at) day')
            )
            ->whereHas('subState', function (Builder $builder) {
                return $builder->whereIn('state_id', [2, 3, 6]);
            })
            ->whereRaw('id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereNotNull('sub_state_id')
            ->groupBy('type_model_order_id', 'sub_state_id', 'year', 'month', 'day')
            ->get();
        return $data;
        ob_clean();
        return Excel::download(new KpiSubStateMonthExport($request), 'Kpi_Sub-Estados-Mes' . date('Y-m-d') . '.xlsx');
    }

    public function diffTimeReception(Request $request)
    {
        ob_clean();
        return Excel::download(new KpiDiffTimeReceptionExport($request), 'Kpi_Diferencia_Dias-' . date('Y-m-d') . '.xlsx');
    }

    public function checkList(Request $request)
    {
        ob_clean();
        return Excel::download(new KpiCheckListExport($request), 'Kpi_Ckeck_List' . date('Y-m-d') . '.xlsx');
    }

    public function kpiInpuOut(Request $request)
    {
        ob_clean();
        return Excel::download(new KpiInpuOutExport($request), 'Kpi_Entradas_Salidas-' . date('Y-m-d') . '.xlsx');
    }

    public function kpiFull(Request $request)
    {
        ob_clean();
        return Excel::download(new KpiFullExport($request), 'Kpi-' . date('Y-m-d') . '.xlsx');
    }

    public function kpiPendingTask(Request $request)
    {
        ob_clean();
        return Excel::download(new KpiPendingTaskExport($request), 'Kpi_Tareas_Pendientes-' . date('Y-m-d') . '.xlsx');
    }

    public function pendingTask(Request $request)
    {
       /* return PendingTask::select(['datetime_start', 'datetime_finish', 'observations', 'vehicle_id', 'task_id', 'total_paused', 'reception_id'])
            ->selectRaw(DB::raw('(select sp.name from state_pending_tasks sp where sp.id = pending_tasks.state_pending_task_id) as state_pending_task_name'))
            // ->selectRaw(DB::raw('(select c.name from campas c where c.id = pending_tasks.campa_id) as campa_name'))
            ->with(array(
                'vehicle' => function ($query) {
                    $query->select(['id', 'plate', 'kms', 'has_environment_label', 'company_id', 'vehicle_model_id'])
                        ->selectRaw(DB::raw('(select c.name from colors c where c.id = vehicles.color_id) as color_name'))
                        ->selectRaw(DB::raw('(select c.name from categories c where c.id = vehicles.category_id) as category_name'))
                        ->selectRaw(DB::raw('(SELECT GROUP_CONCAT((SELECT a.name from accessories a where a.id = av.accessory_id)) as accesory_name from accessory_vehicle av where av.vehicle_id = vehicles.id group By av.vehicle_id) as accesory_name'))
                        ->with([
                            'vehicleModel' => function ($q) {
                                $q->select('id', 'name', 'brand_id')
                                    ->selectRaw(DB::raw('(select b.name from brands b where b.id = vehicle_models.brand_id) as brand_name'));
                            }
                        ])
                        ->where('company_id', Company::ALD);
                },
                'task' => function ($query) {
                    $query->select(['id', 'name', 'sub_state_id'])
                        ->with(array(
                            'subState' => function ($q) {
                                $q->select('id', 'name', 'state_id')->with(['state' => function ($q) {
                                    $q->select('id', 'name');
                                }]);
                            }
                        ));
                },
                'reception' => function($q) {
                    $q->select('id', 'created_at', 'type_model_order_id', 'campa_id')
                    ->with([
                        'typeModelOrder' => function($query) {
                            $query->select('id', 'name');
                        },
                        'campa' => function($query) {
                            $query->select('id', 'name');
                        }
                    ]);
                },
                'userStart' => function ($query) {
                    $query->select('id', 'name');
                },
                'userEnd' => function ($query) {
                    $query->select('id', 'name');
                },
            ))
            ->whereNotNull('reception_id')
            ->where('approved', true)->whereIn('state_pending_task_id', [StatePendingTask::IN_PROGRESS, StatePendingTask::FINISHED])
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
       //     ->whereNotIn('vehicle_id', $vehicle_ids)
            ->get();*/
        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '-1');
        $date = microtime(true);
        $array = explode('.', $date);
        ob_clean();
        return Excel::download(new ExportsPendingTaskExport, 'vehículos-tareas-realizadas-' . date('d-m-Y') . '-' . $array[0] . '.xlsx');
    }

    public function stockVehicle(Request $request)
    {
        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '-1');
        $date = microtime(true);
        $array = explode('.', $date);
        ob_clean();
        return Excel::download(new StockVehiclesExport($request->input('campaId')), 'stock-vehículos-' . date('d-m-Y') . '-' . $array[0] . '.xlsx');
    }
}
