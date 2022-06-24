<?php

namespace App\Exports;

use App\Models\Vehicle;
use App\Views\InKpiView;
use App\Views\OutKpiView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KpiInpuOutExport implements FromArray, WithHeadings
{
    protected $header = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nobiembre', 'Diciembre'];
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array(): array
    {
        $year = $this->request->input('year') ?? date('Y');
        $ids = $this->request->input('typeModelOrderIds') ?? null;

        $in_data = InKpiView::with(['typeModelOrder'])
            ->where('in_year', $year)
            ->where(function ($query) use ($ids) {
                if ($ids) {
                    $query->whereIn('type_model_order_id', $ids);
                }
            })
            ->select(
                DB::raw('count(in_kpi) as `total`'),
                DB::raw('type_model_order_id'),
                DB::raw('in_month')
            )
            ->groupBy('type_model_order_id', 'in_kpi', 'in_month')
            ->get();

        $out_data = OutKpiView::with(['typeModelOrder'])
            ->where('out_year', $year)
            ->where(function ($query) use ($ids) {
                if ($ids) {
                    $query->whereIn('type_model_order_id', $ids);
                }
            })
            ->select(
                DB::raw('count(out_kpi) as `total`'),
                DB::raw('type_model_order_id'),
                DB::raw('out_month')
            )
            ->groupBy('type_model_order_id', 'out_kpi', 'out_month')
            ->get();

        $variable = [];
        foreach ($in_data as $key => $v) {
            $variable[$v['typeModelOrder']['name']][(int) $v['in_month']] = $v['total'] ?? 0;
        }

        $value[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

        $value[0][0] = 'Año ' . $year;

        $value[] = ['Entradas', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];
        $value[] = ['Salidas', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];
        $value[] = ['Stock', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];

        $value[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

        $value[] =  ['Entrada ', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nobiembre', 'Diciembre'];

        foreach ($variable as $key => $v) {
            for ($i = 1; $i <= 12; $i++) {
                $value[1][$i] = strval(($v[$i] ?? 0) + (int) $value[1][$i]);
            }
            $value[] = [
                $key,
                strval($v['1'] ?? 0),
                strval($v['2'] ?? 0),
                strval($v['3'] ?? 0),
                strval($v['4'] ?? 0),
                strval($v['5'] ?? 0),
                strval($v['6'] ?? 0),
                strval($v['7'] ?? 0),
                strval($v['8'] ?? 0),
                strval($v['9'] ?? 0),
                strval($v['10'] ?? 0),
                strval($v['11'] ?? 0),
                strval($v['12'] ?? 0)
            ];
        }

        $variable = [];
        foreach ($out_data as $key => $v) {
            $variable[$v['typeModelOrder']['name']][(int) $v['out_month']] = $v['total'] ?? 0;
        }

        $value[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];
        $value[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

        $value[] =  ['Salidas ', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nobiembre', 'Diciembre'];

        foreach ($variable as $key => $v) {
            for ($i = 1; $i <= 12; $i++) {
                $value[2][$i] = strval(($v[$i] ?? 0) + (int) $value[2][$i]);
            }
            $value[] = [
                $key,
                strval($v['1'] ?? 0),
                strval($v['2'] ?? 0),
                strval($v['3'] ?? 0),
                strval($v['4'] ?? 0),
                strval($v['5'] ?? 0),
                strval($v['6'] ?? 0),
                strval($v['7'] ?? 0),
                strval($v['8'] ?? 0),
                strval($v['9'] ?? 0),
                strval($v['10'] ?? 0),
                strval($v['11'] ?? 0),
                strval($v['12'] ?? 0)
            ];
        }

        $stok = Vehicle::withTrashed()
            ->with(['typeModelOrder'])
            ->whereRaw('YEAR(created_at) = ' . $year)
            ->filter($this->request->all())
            ->select(
                DB::raw('count(id) as `total`'),
                DB::raw('count(deleted_at) as `deleted`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month'),
                DB::raw('type_model_order_id')
            )
            ->groupBy('type_model_order_id', 'year', 'month')
            ->get();


        $variable = [];
        foreach ($stok as $key => $v) {
            $variable[$v['typeModelOrder']['name']][(int) $v['month']] = ($v['total'] ?? 0) - ($v['deleted'] ?? 0);
        }

        $value[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];
        $value[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

        $value[] =  ['Stock ', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nobiembre', 'Diciembre'];

        foreach ($variable as $key => $v) {
            for ($i = 1; $i <= 12; $i++) {
                $value[3][$i] = strval(($v[$i] ?? 0) + (int) $value[3][$i]);
            }
            $value[] = [
                $key,
                strval($v['1'] ?? 0),
                strval($v['2'] ?? 0),
                strval($v['3'] ?? 0),
                strval($v['4'] ?? 0),
                strval($v['5'] ?? 0),
                strval($v['6'] ?? 0),
                strval($v['7'] ?? 0),
                strval($v['8'] ?? 0),
                strval($v['9'] ?? 0),
                strval($v['10'] ?? 0),
                strval($v['11'] ?? 0),
                strval($v['12'] ?? 0)
            ];
        }

        $stok_now = Vehicle::withTrashed()
            ->with(['typeModelOrder'])
            ->whereRaw('YEAR(created_at) = ' . (int) date('Y'))
            ->whereRaw('MONTH(created_at) = ' . (int) date('m'))
            //    ->whereRaw('DAY(created_at) = ' . (int) date('d'))
            ->filter($this->request->all())
            ->select(
                DB::raw('count(id) as `total`'),
                DB::raw('count(deleted_at) as `deleted`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') date"),
                DB::raw('YEAR(created_at) year'),
                DB::raw('MONTH(created_at) month'),
                DB::raw('DAY(created_at) day'),
                DB::raw('type_model_order_id')
            )
            ->groupBy('type_model_order_id', 'year', 'month', 'day')
          //  ->orderByRaw('DAY(created_at) desc')
            ->get();

        $variable = [];
        $total = 0;
        foreach ($stok_now as $key => $v) {
            $x = ($v['total'] ?? 0) - ($v['deleted'] ?? 0);
            $total = $total + $x;
            $variable[$v['typeModelOrder']['name'] . ' - ' . $v['day']][1] = $x;
        }

        $value[] = ['', '', '', '', ''];
        $value[] = ['', '', '', '', ''];

        $value[] =  ['Stock ' . date('m/Y'), 'Totales', '%', 'Ocupacion', '%'];

        foreach ($variable as $key => $v) {
            $value[] = [
                $key,
                strval($v[1] ?? 0),
                strval($this->obtenerPorcentaje((int) $v[1] ?? 0, $total)),
                500,
                strval($this->obtenerPorcentaje((int) $v[1] ?? 0, 500)),
            ];
        }

        return $value;
    }

    public function obtenerPorcentaje($cantidad, $total)
    {
        $porcentaje = ((float)$cantidad * 100) / $total; // Regla de tres
        $porcentaje = round($porcentaje, 2);  // Quitar los decimales
        return $porcentaje;
    }

    public function headings(): array
    {
        return $this->header;
    }
}
