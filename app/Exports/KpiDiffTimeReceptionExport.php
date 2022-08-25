<?php

namespace App\Exports;

use App\Models\Reception;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KpiDiffTimeReceptionExport implements FromArray, WithHeadings
{
    protected $header = ['Negocio', 'Total vehículos', 'Número vehículos < 15', 'Número vehículos < 30', 'Número vehículos < 45', 'Número vehículos > 45'];
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array(): array
    {
        $data_now = Reception::with(['typeModelOrder'])
            ->filter(array_merge($this->request->all(), ['defleetingAndDelivery' => 1]))
            // ->filter($this->request->all())
            ->select(
                DB::raw('(SELECT type_model_order_id FROM vehicles WHERE id = receptions.vehicle_id) as type_model_order_id'),
                DB::raw('CASE WHEN TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) < 15 THEN 14 WHEN TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) < 30 THEN 29 WHEN TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) < 45 THEN 44 ELSE 45 END AS bit'),
                DB::raw('count(vehicle_id) as total')
            )
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereRaw('id IN(SELECT MAX(id) FROM receptions r GROUP BY vehicle_id)')
            ->groupBy('type_model_order_id', 'bit')
            ->get();

        $acum = 0;
        $total = [];
        $variable = [];
        $variable['Totales'] = [0, 0, 0, 0];
        foreach ($data_now as $key => $v) {
            $x = $v['total'] ?? 0;
            $a = $v['typeModelOrder']['name'];
            $total[$a] = ($total[$a] ?? 0) + $x;
            $variable[$a][$v['bit']] = $x;
            $variable['Totales'][$v['bit']] = ($variable['Totales'][$v['bit']] ?? 0) + $x;
            $acum = $acum + $x;
        }

        foreach ($variable as $key => $v) {
            $value[] = [
                $key,
                strval($total[$key] ?? 0),
                strval($v[14] ?? 0),
                strval($v[29] ?? 0),
                strval($v[44] ?? 0),
                strval($v[45] ?? 0)
            ];
        }

        if (!$value) {
            $value = [];
        } else {
            $value[0][1] = strval($acum);
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
