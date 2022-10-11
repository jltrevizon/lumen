<?php

namespace App\Exports;

use App\Models\Vehicle;
use App\Models\Campa;
use App\Views\InKpiView;
use App\Views\OutKpiView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KpiInpuOutExport implements FromArray, WithHeadings
{
    protected $header = ['Entradas y salidas', '', '', '', '', '', '', '', '', '', '', '', ''];
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array(): array
    {
        $year = $this->request->input('year') ?? date('Y');
        $ids = $this->request->input('typeModelOrderIds') ?? null;
        $campas = $this->request->input('campas') ?? null;

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
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
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
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->groupBy('type_model_order_id', 'out_kpi', 'out_month')
            ->get();

        $variable = [];
        foreach ($in_data as $key => $v) {
            $variable[$v['typeModelOrder']['name']][(int) $v['in_month']] = $v['total'] ?? 0;
        }

        $value[] = ['Año ' . $year, 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nobiembre', 'Diciembre'];

        $value[] = ['Entradas', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];
        $value[] = ['Salidas', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];

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

        $stok = Vehicle::with(['typeModelOrder'])
            ->whereRaw('YEAR(created_at) = ' . $year)
            ->filter(array_merge($this->request->all(), ['defleetingAndDelivery' => 1]))
            ->select(
                DB::raw('count(id) as `total`'),
                DB::raw('count(deleted_at) as `deleted`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month'),
                DB::raw('type_model_order_id')
            )
            ->whereRaw('id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->groupBy('type_model_order_id', 'year', 'month')
            ->get();


        $variable = [];
        foreach ($stok as $key => $v) {
            $variable[$v['typeModelOrder']['name']][(int) $v['month']] = ($v['total'] ?? 0) - ($v['deleted'] ?? 0);
        }

        $stok_now = Vehicle::with(['typeModelOrder'])
            ->filter(array_merge($this->request->all(), ['defleetingAndDelivery' => 1]))
            ->select(
                DB::raw('count(id) as `total`'),
                DB::raw('count(deleted_at) as `deleted`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') date"),
                DB::raw('type_model_order_id')
            )
            ->whereRaw('id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->groupBy('type_model_order_id')
            ->get();

        $variable = [];
        $total = 0;
        foreach ($stok_now as $key => $v) {
            $x = ($v['total'] ?? 0) - ($v['deleted'] ?? 0);
            $total = $total + $x;
            $variable[$v['typeModelOrder']['name']][1] = $x;
        }

        $value[] = ['', '', '', '', ''];
        $value[] = ['', '', '', '', ''];

        $campas = Campa::filter(['ids' => $campas])
            ->select(
                DB::raw('sum(ocupation) as `ocupacion`')
            )
            ->get();
        $ocupacion = $campas[0]['ocupacion'];

        $value[] =  ['Stock campa actual', 'Totales', '%', 'Ocupacion', '%'];
        $value[] =  ['TOTAL', strval($total ?? 0), strval($this->obtenerPorcentaje((int) $total ?? 0, $total)), $ocupacion, strval($this->obtenerPorcentaje((int) $total ?? 0, $ocupacion))];

        foreach ($variable as $key => $v) {
            $value[] = [
                $key,
                strval($v[1] ?? 0),
                strval($this->obtenerPorcentaje((int) $v[1] ?? 0, $total)),
                $ocupacion,
                strval($this->obtenerPorcentaje((int) $v[1] ?? 0, $ocupacion)),
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
