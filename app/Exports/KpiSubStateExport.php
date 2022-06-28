<?php

namespace App\Exports;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Database\Eloquent\Builder;

class KpiSubStateExport implements FromArray
{
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array(): array
    {

        $value[] = ['', '', 'Número de lo que hay en stock', '% de lo que hay en stock'];

        $data = Vehicle::withTrashed()
            ->with(['typeModelOrder', 'subState.state'])
            ->filter($this->request->all())
            ->select(
                DB::raw('count(sub_state_id) as `total`'),
                DB::raw('type_model_order_id'),
                DB::raw('sub_state_id')
            )
            ->whereHas('subState', function (Builder $builder) {
                return $builder->whereIn('state_id', [2, 3, 6]);
            })
            ->whereRaw('id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->groupBy('type_model_order_id', 'sub_state_id')
            ->get();

        $value[] = ['No Disponible', 'Total de lo que estan en estado predisponible + taller + pte venta vo', '', '%'];
        $index = count($value) - 1;
        $total[$index] = 0;

        foreach ($data as $key => $v) {
            $x =  $v['total'] ?? 0;
            $total[$index] = $total[$index] + $x;
            $value[] = [$v['subState']['state']['name'], $v['typeModelOrder']['name'] . ' - ' . $v['subState']['name'], strval($x), '%'];
        }

        $value[$index][2] = $total[$index];

        $data = Vehicle::withTrashed()
            ->with(['typeModelOrder', 'subState.state'])
            ->filter($this->request->all())
            ->select(
                DB::raw('count(sub_state_id) as `total`'),
                DB::raw('type_model_order_id'),
                DB::raw('sub_state_id')
            )
            ->whereHas('subState', function (Builder $builder) {
                return $builder->whereIn('state_id', [1]);
            })
            ->whereRaw('id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->groupBy('type_model_order_id', 'sub_state_id')
            ->get();

        $value[] = ['', '', '', ''];
        $value[] = ['', '', '', ''];

        $value[] = ['Disponible', 'Total de lo que estan en estado disponible', '', '%'];
        $index = count($value) - 1;
        $total[$index] = 0;

        foreach ($data as $key => $v) {
            $x =  $v['total'] ?? 0;
            $total[$index] = $total[$index] + $x;
            $value[] = [$v['subState']['state']['name'], $v['typeModelOrder']['name'] . ' - ' . $v['subState']['name'] . $index, strval($x), '%'];
        }

        $value[$index][2] = $total[$index];

        $acum = 0;
        for ($i = 0; $i < count($total); $i++) {
            $acum += $total[$i] ?? 0;
        }

        for ($i = 0; $i < count($value); $i++) {
            if ($value[$i][3] == '%') {
                $value[$i][3] = $this->obtenerPorcentaje((int) $value[$i][2], $acum);
            }
        }

        return $value;
    }

    public function obtenerPorcentaje($cantidad, $total)
    {
        $porcentaje = ((float)$cantidad * 100) / $total; // Regla de tres
        $porcentaje = round($porcentaje, 2);  // Quitar los decimales
        return $porcentaje;
    }
}
