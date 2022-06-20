<?php

namespace App\Exports;

use App\Views\KpiView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KpiInpuOutExport implements FromArray, WithHeadings
{
    public function __construct(int $year)
    {
        $this->year = $year;
    }

    public function collection()
    {
    }

    public function array(): array
    {
        $in_data = KpiView::with(['typeModelOrder'])
            ->where('in_year', $this->year)
            ->select(
                DB::raw('count(in_kpi) as `total`'),
                DB::raw('view_kpis.type_model_order_id'),
                DB::raw('view_kpis.in_month')
            )
            ->groupBy('type_model_order_id', 'in_kpi', 'in_month')
            ->get();

        $out_data = KpiView::with(['typeModelOrder'])
            ->where('out_year', $this->year)
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

        $value[] =  ['Entrada', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Optubre', 'Nobiembre', 'Diciembre'];

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

        return $value;
    }

    public function headings(): array
    {
        return [
            'Negocio',
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Optubre',
            'Noviembre',
            'Diciembre'
        ];
    }
}
