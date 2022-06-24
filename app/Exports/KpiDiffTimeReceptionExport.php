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
            DB::raw("DATE_FORMAT(updated_at, '%m-%Y') date"),
            DB::raw('YEAR(updated_at) year, MONTH(updated_at) month')
        )
        ->whereRaw('YEAR(updated_at) = ' . $year)
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

        $data = Reception::with(['typeModelOrder', 'vehicle'])
        ->filter($this->request->all())
        ->select(
            DB::raw('id'),
            DB::raw('vehicle_id'),
            DB::raw('(SELECT type_model_order_id FROM vehicles WHERE id = receptions.vehicle_id) as type_model_order_id'),
            DB::raw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) AS total'),
            DB::raw("DATE_FORMAT(updated_at, '%m-%Y') date"),
            DB::raw('YEAR(updated_at) year, MONTH(updated_at) month')
        )
        ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
        ->whereRaw('YEAR(updated_at) = ' . $year)
        ->whereRaw('id IN(SELECT MAX(id) FROM receptions r GROUP BY vehicle_id)')
        ->groupBy('type_model_order_id', 'vehicle_id', 'year', 'month')
        ->get();



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
