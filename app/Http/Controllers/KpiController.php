<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\KpiInpuOutExport;
use App\Exports\KpiSubStateExport;
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
        /*$data = Vehicle::with(['typeModelOrder', 'subState.state'])
            ->whereRaw('YEAR(created_at) = ' . 2022)
            ->whereNull('deleted_at')
            ->select(
                DB::raw('count(id) as `total`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month'),
                DB::raw('type_model_order_id'),
                DB::raw('sub_state_id')
            )
            ->groupBy('type_model_order_id', 'sub_state_id')
            ->get();
        return $data;*/
        ob_clean();
        return Excel::download(new KpiSubStateExport($request), 'Kpi_Sub-Estados' . date('Y-m-d') . '.xlsx');
    }



    public function kpiInpuOut(Request $request)
    {
        ob_clean();
        return Excel::download(new KpiInpuOutExport($request), 'Kpi_Entradas_Salidas-' . date('Y-m-d') . '.xlsx');
    }
}
