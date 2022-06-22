<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Views\KpiView;
use App\Exports\KpiInpuOutExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

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
        $in_data = KpiView::with(['typeModelOrder'])
            ->where('out_year',  date('Y'))
            ->select(
                DB::raw('count(in_kpi) as `total`'),
                DB::raw('view_kpis.type_model_order_id'),
                DB::raw('view_kpis.in_month')
            )
            ->groupBy('type_model_order_id', 'in_kpi', 'in_month')
            ->get();

        $out_data = KpiView::with(['typeModelOrder'])
            ->where('out_year',  date('Y'))
            ->select(
                DB::raw('count(out_kpi) as `total`'),
                DB::raw('view_kpis.type_model_order_id'),
                DB::raw('view_kpis.out_month')
            )
            ->groupBy('type_model_order_id', 'out_kpi', 'out_month')
            ->get();

        $variable = [];
        foreach ($in_data as $key => $v) {
            $variable[$v['typeModelOrder']['name']][(int) $v['in_month']] = $v['total'] ?? 0;
        }

        $value[] =  ['Entrada', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nobiembre', 'Diciembre'];

        foreach ($variable as $key => $v) {
            $value[] = [
                $key,
                $v['1'] ?? 0,
                $v['2'] ?? 0,
                $v['3'] ?? 0,
                $v['4'] ?? 0,
                $v['5'] ?? 0,
                $v['6'] ?? 0,
                $v['7'] ?? 0,
                $v['8'] ?? 0,
                $v['9'] ?? 0,
                $v['10'] ?? 0,
                $v['11'] ?? 0,
                $v['12'] ?? 0
            ];
        }

        $variable = [];
        foreach ($out_data as $key => $v) {
            $variable[$v['typeModelOrder']['name']][(int) $v['out_month']] = $v['total'] ?? 0;
        }

        $value[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

        $value[] =  ['Salidas', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Optubre', 'Nobiembre', 'Diciembre'];

        foreach ($variable as $key => $v) {
            $value[] = [
                $key,
                $v['1'] ?? 0,
                $v['2'] ?? 0,
                $v['3'] ?? 0,
                $v['4'] ?? 0,
                $v['5'] ?? 0,
                $v['6'] ?? 0,
                $v['7'] ?? 0,
                $v['8'] ?? 0,
                $v['9'] ?? 0,
                $v['10'] ?? 0,
                $v['11'] ?? 0,
                $v['12'] ?? 0
            ];
        }

        $kpis = KpiView::all();
        (new FastExcel($value))->export('kpis.xlsx');
        return redirect('/kpis.xlsx');
    }
}
