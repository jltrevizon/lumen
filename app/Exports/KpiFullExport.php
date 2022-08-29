<?php

namespace App\Exports;

use App\Models\Vehicle;
use App\Models\Campa;
use App\Models\Company;
use App\Models\PendingTask;
use App\Models\Reception;
use App\Views\InKpiView;
use App\Views\OutKpiView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Database\Eloquent\Builder;

class KpiFullExport implements FromArray, WithHeadings, WithStyles
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

        $value[] = ['Año ' . $year, 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

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

        /** End KPI */

        $total = [];
        $value[] = ['', '', '', '', ''];
        $value[] = ['Días en campa', '', '', '', ''];

        /** KPI DiffTimeReception */

        $vehicle_ids = collect(Vehicle::filter(['defleetingAndDelivery' => 0])->get())->map(function ($item) {
            return $item->id;
        })->toArray();
        $data_now = Reception::with(['typeModelOrder'])
            ->filter($this->request->all())
            ->select(
                DB::raw('(SELECT type_model_order_id FROM vehicles WHERE id = receptions.vehicle_id) as type_model_order_id'),
                DB::raw('CASE WHEN TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) < 15 THEN 14 WHEN TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) < 30 THEN 29 WHEN TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) < 45 THEN 44 ELSE 45 END AS bit'),
                DB::raw('count(vehicle_id) as total')
            )
            ->whereNotIn('vehicle_id', $vehicle_ids)
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereRaw('id IN(SELECT MAX(id) FROM receptions r GROUP BY vehicle_id)')
            ->groupBy('type_model_order_id', 'bit')
            ->get();

        $acum = 0;
        $total = [];
        $variable = [];
        $variable['Totales'] = [0, 0, 0, 0];
        foreach ($data_now as $key => $v) {
            if ($v['typeModelOrder']) {
                $x = $v['total'] ?? 0;
                $a = $v['typeModelOrder']['name'];
                $total[$a] = ($total[$a] ?? 0) + $x;
                $variable[$a][$v['bit']] = $x;
                $variable['Totales'][$v['bit']] = ($variable['Totales'][$v['bit']] ?? 0) + $x;
                $acum = $acum + $x;
            }
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

        /** End KPI */

        $total = [];
        $value[] = ['', '', '', '', '', ''];
        $value[] = ['', '', '', '', '', ''];

        /** KPI SUB STATES */

        $value[] = ['Situación stock actual', '', '', ''];
        $base_index = count($value) + 1;
        $value[] = ['', '', 'Número de lo que hay en stock', '% de lo que hay en stock', '', ''];
        $value[] = ['Total general', 'Total no disponibles y disponibles', '', '100', ''];
        $value[] = ['No Disponible', 'Total de lo que están en estado predisponible + taller + pte venta vo', '', '%', ''];

        /* Taller */

        $data = Vehicle::with(['typeModelOrder', 'subState.state'])
            ->filter(array_merge($this->request->all(), ['defleetingAndDelivery' => 1]))
            ->select(
                DB::raw('count(sub_state_id) as `total`'),
                DB::raw('type_model_order_id'),
                DB::raw('sub_state_id')
            )
            ->whereHas('subState', function (Builder $builder) {
                return $builder->whereIn('state_id', [2]);
            })
            ->whereRaw('id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->groupBy('type_model_order_id', 'sub_state_id')
            ->get();

        $value[] = ['Taller', 'Total de lo que están en estado taller', '', '%', ''];
        $index = count($value) - 1;
        $total[$index] = 0;

        foreach ($data as $key => $v) {
            $x =  $v['total'] ?? 0;
            $total[$index] = $total[$index] + $x;
            $value[] = [$v['subState']['state']['name'], $v['typeModelOrder']['name'] . ' - ' . $v['subState']['name'], strval($x), '%', 'Taller'];
        }

        $value[$index][2] = $total[$index];
        $total_taller = $total[$index];

        /* Pendiente V.O. */

        $data = Vehicle::with(['typeModelOrder', 'subState.state'])
            ->filter(array_merge($this->request->all(), ['defleetingAndDelivery' => 1]))
            ->select(
                DB::raw('count(sub_state_id) as `total`'),
                DB::raw('type_model_order_id'),
                DB::raw('sub_state_id')
            )
            ->whereHas('subState', function (Builder $builder) {
                return $builder->whereIn('state_id', [3]);
            })
            ->whereRaw('id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->groupBy('type_model_order_id', 'sub_state_id')
            ->get();

        $value[] = ['Pendiente Venta V.O.', 'Total de lo que están en estado pendiente de venta vo', '', '%', ''];
        $index = count($value) - 1;
        $total[$index] = 0;

        foreach ($data as $key => $v) {
            $x =  $v['total'] ?? 0;
            $total[$index] = $total[$index] + $x;
            $value[] = [$v['subState']['state']['name'], $v['typeModelOrder']['name'] . ' - ' . $v['subState']['name'], strval($x), '%', 'Pendiente Venta V.O.'];
        }

        $value[$index][2] = $total[$index];
        $total_pendiente_venta = $total[$index];

        /* Predisponible */

        $data = Vehicle::with(['typeModelOrder', 'subState.state'])
            ->filter(array_merge($this->request->all(), ['defleetingAndDelivery' => 1]))
            ->select(
                DB::raw('count(sub_state_id) as `total`'),
                DB::raw('type_model_order_id'),
                DB::raw('sub_state_id')
            )
            ->whereHas('subState', function (Builder $builder) {
                return $builder->whereIn('state_id', [6]);
            })
            ->whereRaw('id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->groupBy('type_model_order_id', 'sub_state_id')
            ->get();

        $value[] = ['Pre-disponible', 'Total de lo que están en estado predisponible', '', '%', ''];
        $index = count($value) - 1;
        $total[$index] = 0;

        foreach ($data as $key => $v) {
            $x =  $v['total'] ?? 0;
            $total[$index] = $total[$index] + $x;
            $value[] = [$v['subState']['state']['name'], $v['typeModelOrder']['name'] . ' - ' . $v['subState']['name'], strval($x), '%', 'Pre-disponible'];
        }

        $value[$index][2] = $total[$index];
        $total_predisponible = $total[$index];


        /* Disponible */

        $data = Vehicle::with(['typeModelOrder', 'subState.state'])
            ->filter(array_merge($this->request->all(), ['defleetingAndDelivery' => 1]))
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

        $value[] = ['Disponible', 'Total de lo que estan en estado disponible', '', '%', 'Disponible'];
        $index = count($value) - 1;
        $total[$index] = 0;

        foreach ($data as $key => $v) {
            $x =  $v['total'] ?? 0;
            $total[$index] = $total[$index] + $x;
            $value[] = [$v['subState']['state']['name'], $v['typeModelOrder']['name'] . ' - ' . $v['subState']['name'], strval($x), '%', 'Disponible'];
        }

        $value[$index][2] = $total[$index];
        $total_disponibles = $total[$index];

        $total_no_disponibles = $total_taller + $total_predisponible + $total_pendiente_venta;
        $total_general = $total_disponibles + $total_no_disponibles;
       
        $value[$base_index][2] = strval($total_general);
        $value[$base_index + 1][2] = strval($total_no_disponibles);

        for ($i = 0; $i < count($value); $i++) {
            if ($value[$i][3] == '%') {
                $value[$i][3] = $this->obtenerPorcentaje((int) $value[$i][2], $total_general);
                $val = $value[$i][4] == 'Disponible' ? $total_disponibles : $total_no_disponibles;
                $value[$i][4] = round((int) $value[$i][2] / $val * 100, 2);
            }
        }

        /** End KPI */

        $total = [];
        $value[] = ['', '', '', '', ''];
        $value[] = ['Checklist pendientes', '', '', '', ''];

        /** KPI Check List */

        $data = Vehicle::whereHas('lastUnapprovedGroupTask')
            ->whereHas('campa', function (Builder $builder) {
                return $builder->where('company_id', Company::ALD);
            })
            ->select(
                DB::raw('count(*) vehiculos'),
                DB::raw('sum((select count(*) from pending_tasks where vehicle_id = vehicles.id and task_id = 2 and approved = 1 and (state_pending_task_id in (1, 2) or (state_pending_task_id is null and comment_state is null)) )) chapa'),
                DB::raw('sum((select count(*) from pending_tasks where vehicle_id = vehicles.id and task_id = 3 and approved = 1 and (state_pending_task_id in (1, 2) or (state_pending_task_id is null and comment_state is null)) )) mecanica')
            )
            ->get();

        $value[] = ['Checklist pendientes', 'Checklist pendientes (vehículos en estado pendiente check) totales.', strval($data[0]['vehiculos'])];
        $value[] = ['Mecánica', 'Número de tareas de mecánica de vehículos pendiente check', strval($data[0]['mecanica'])];
        $value[] = ['Chapa', 'Número de tareas de chapa de vehiculos pendiente check.', strval($data[0]['chapa'])];


        /** End KPI */

        $total = [];
        $value[] = ['', '', '', '', ''];
        $value[] = ['Tareas pendientes', '', '', '', ''];

        /** KPI PendingTasks */

        $data_now = PendingTask::with(['task'])
            ->filter($this->request->all())
            ->select(
                DB::raw('id'),
                DB::raw('task_id'),
                DB::raw('state_pending_task_id'),
                DB::raw('COUNT(id) as total'),
                DB::raw('(SELECT type_model_order_id FROM vehicles WHERE id = pending_tasks.vehicle_id) as type_model_order_id')
            )
            ->whereRaw('group_task_id IN(SELECT MAX(id) FROM group_tasks g GROUP BY vehicle_id)')
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereIn('state_pending_task_id', [1, 2])
            ->where('approved', 1)
            ->groupBy('task_id', 'state_pending_task_id')
            ->orderBy('task_id')
            ->get();


        $variable = [];
        foreach ($data_now as $key => $v) {
            $x = ($v['total'] ?? 0);
            $b = $v['task']['name'];
            $variable[$b][$v['state_pending_task_id'] ?? 0] = $x;
            $total[$b] = $total[$b] ?? 0 + $x;
        }

        foreach ($variable as $key => $v) {
            $value[] = [
                $key,
                strval($v[1] ?? 0),
                strval($v[2] ?? 0),
                strval(($v[1] ?? 0) + ($v[2] ?? 0))
            ];
        }

        if (!$value) {
            $value = [];
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

    public function styles()
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

}
