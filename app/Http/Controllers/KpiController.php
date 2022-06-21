<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Views\KpiView;
use App\Exports\KpiInpuOutExport;
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

    public function kpiInpuOut(Request $request)
    {
        $year = $request->input('year');
        return Excel::download(new KpiInpuOutExport, 'kpi-' . date('d-m-Y') . '-' . '.xlsx');
    }
}
