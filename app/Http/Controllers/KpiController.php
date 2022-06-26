<?php

namespace App\Http\Controllers;

use App\Exports\KpiCheckListExport;
use App\Exports\KpiDiffTimeReceptionExport;
use Illuminate\Http\Request;
use App\Exports\KpiInpuOutExport;
use App\Exports\KpiPendingTaskExport;
use App\Exports\KpiSubStateExport;
use App\Models\GroupTask;
use App\Models\PendingTask;
use App\Models\Reception;
use App\Models\Vehicle;
use App\Views\InKpiView;
use App\Views\OutKpiView;
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
        $data = InKpiView::with($this->getWiths($request->with))
            ->filter($request->all())
            ->select(
                DB::raw('count(in_kpi) as `total`'),
                DB::raw('view_kpis.type_model_order_id'),
                DB::raw('view_kpis.in_month')
            )
            ->groupBy('type_model_order_id', 'in_kpi', 'in_month')
            ->get();

        return $this->getDataResponse($data, HttpFoundationResponse::HTTP_OK);
    }

    public function out(Request $request)
    {
        $data = OutKpiView::with($this->getWiths($request->with))
            ->filter($request->all())
            ->select(
                DB::raw('count(out_kpi) as `total`'),
                DB::raw('view_kpis.type_model_order_id'),
                DB::raw('view_kpis.out_month')
            )
            ->groupBy('type_model_order_id', 'out_kpi', 'out_month')
            ->get();
        return $this->getDataResponse($data, HttpFoundationResponse::HTTP_OK);
    }

    public function subStates(Request $request)
    {
        /*$data = Vehicle::withTrashed()
        ->with(['typeModelOrder', 'subState.state'])
        ->filter($request->all())
        ->select(
            DB::raw('count(id) as `total`'),
            DB::raw('type_model_order_id'),
            DB::raw('sub_state_id')
        )
        ->groupBy('type_model_order_id', 'sub_state_id')
        ->get();
        return $data;*/
        ob_clean();
        return Excel::download(new KpiSubStateExport($request), 'Kpi_Sub-Estados-' . date('Y-m-d') . '.xlsx');
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

    public function kpiPendingTask(Request $request)
    {
        ob_clean();
        return Excel::download(new KpiPendingTaskExport($request), 'Kpi_Tareas_Pendientes-' . date('Y-m-d') . '.xlsx');
    }
}
