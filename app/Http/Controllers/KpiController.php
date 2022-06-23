<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Views\KpiView;
use App\Exports\KpiInpuOutExport;
use App\Models\Reception;
use App\Models\Vehicle;
use App\Views\InKpiView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class KpiController extends Controller
{
    public function index(Request $request)
    {
        $data = KpiView::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate();
        return $this->getDataResponse($data, HttpFoundationResponse::HTTP_OK);
    }

    public function inpu(Request $request)
    {
        $data = KpiView::with($this->getWiths($request->with))
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
        $data = KpiView::with($this->getWiths($request->with))
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
        $data = KpiView::with($this->getWiths($request->with))
            ->filter($request->all())
            ->select(
                DB::raw('count(sub_state_id) as `total`'),
                DB::raw('type_model_order_id'),
                DB::raw('sub_state_id'),
                DB::raw('state_id')
            )
            ->groupBy('sub_state_id')
            ->get();
        return $this->getDataResponse($data, HttpFoundationResponse::HTTP_OK);
    }



    public function kpiInpuOut(Request $request)
    {
        ob_clean();
        return Excel::download(new KpiInpuOutExport($request), 'Kpi_Entradas_Salidas-' . date('Y-m-d') . '.xlsx');
    }
}
