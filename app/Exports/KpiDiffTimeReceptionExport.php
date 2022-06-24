<?php

namespace App\Exports;

use App\Models\Reception;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KpiDiffTimeReceptionExport implements FromArray, WithHeadings
{
    protected $header = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nobiembre', 'Diciembre'];
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array(): array
    {
        $year = $this->request->input('year') ?? date('Y');
        $data = Reception::with(['typeModelOrder', 'vehicle'])
            ->filter($this->request->all())
            ->select(
                DB::raw('id'),
                DB::raw('vehicle_id'),
                DB::raw('(SELECT type_model_order_id FROM vehicles WHERE id = receptions.vehicle_id) as type_model_order_id'),
                DB::raw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) AS total'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month')
            )
            ->whereRaw('YEAR(created_at) = ' . $year)
            ->whereRaw('id IN(SELECT MAX(id) FROM receptions r GROUP BY vehicle_id)')
            ->whereRaw('id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->groupBy('type_model_order_id', 'vehicle_id', 'year', 'month')
            ->get();

        $variable = [];
        foreach ($data as $key => $v) {
            $a = $v['typeModelOrder']['name'];
            $b = $v['vehicle']['plate'];
            $variable[$a . ' - ' . $b][(int) $v['month']] = $v['total'] ?? 0;
        }

        $value[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

        $value[0][0] = 'Año ' . $year;

        $value[] = ['Dias', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];

        $value[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

        $value[] =  ['Dias ', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nobiembre', 'Diciembre'];

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

        $data_now = Reception::with(['typeModelOrder', 'vehicle'])
            ->filter($this->request->all())
            ->select(
                DB::raw('id'),
                DB::raw('vehicle_id'),
                DB::raw('(SELECT type_model_order_id FROM vehicles WHERE id = receptions.vehicle_id) as type_model_order_id'),
                DB::raw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) AS total'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') date"),
                DB::raw('YEAR(created_at) year'),
                DB::raw('MONTH(created_at) month'),
                DB::raw('DAY(created_at) day')
            )
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereRaw('YEAR(created_at) = ' . $year)
            ->whereRaw('MONTH(created_at) = ' . date('m'))
            ->whereRaw('id IN(SELECT MAX(id) FROM receptions r GROUP BY vehicle_id)')
            ->groupBy('type_model_order_id', 'vehicle_id', 'year', 'month', 'day')
            ->get();


        $variable = [];
        $total = 0;
        foreach ($data_now as $key => $v) {
            $x = ($v['total'] ?? 0) - ($v['deleted'] ?? 0);
            $total = $total + $x;
            $a = $v['typeModelOrder']['name'];
            $b = $v['vehicle']['plate'];
            $variable[$a . ' - ' . $b . ' - ' . $v['day'] . '/' . $v['date']][1] = $x;
        }

        $value[] = ['', '', '', '', ''];
        $value[] = ['', '', '', '', ''];

        $value[] =  ['Dias ' . date('m/Y'), 'Total', '%'];

        foreach ($variable as $key => $v) {
            $value[] = [
                $key,
                strval($v[1] ?? 0),
                strval($this->obtenerPorcentaje((int) $v[1] ?? 0, $total))
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
