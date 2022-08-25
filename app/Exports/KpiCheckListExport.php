<?php

namespace App\Exports;

use App\Models\Vehicle;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;


class KpiCheckListExport implements FromArray, WithHeadings
{
    protected $header = ['Invarat'];
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array(): array
    {

        $data = Vehicle::whereHas('lastUnapprovedGroupTask')
            ->whereHas('campa', function (Builder $builder) {
                return $builder->where('company_id', Company::ALD);
            })
            ->select(
                DB::raw('count(*) vehiculos'),
                DB::raw('sum((select count(*) from pending_tasks where vehicle_id = vehicles.id and task_id = 2 and approved = 1 and (state_pending_task_id in (1, 2) or (state_pending_task_id is null and comment_state is null)) )) chapa'),
                DB::raw('sum((select count(*) from pending_tasks where vehicle_id = vehicles.id and task_id = 3 and approved = 1 and (state_pending_task_id in (1, 2) or (state_pending_task_id is null and comment_state is null)) )) mecanica')
            )
            // ->filter($request->all())
            ->get();

/*
        $data = Vehicle::with(['subState.state'])
            ->select(
                DB::raw('count(*) vehiculos'),
                DB::raw('sum((select count(*) from pending_tasks where vehicle_id = vehicles.id and task_id = 2 and approved = 1 and (state_pending_task_id in (1, 2) or (state_pending_task_id is null and comment_state is null)) )) chapa'),
                DB::raw('sum((select count(*) from pending_tasks where vehicle_id = vehicles.id and task_id = 3 and approved = 1 and (state_pending_task_id in (1, 2) or (state_pending_task_id is null and comment_state is null)) )) mecanica')
            )
            ->whereRaw('sub_state_id = 11')
            ->whereRaw('id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->get();
*/
            $value[] = ['Checklist pendientes', 'Checklist pendientes (vehículos en estado pendiente check) totales.', strval($data[0]['vehiculos'])];
            $value[] = ['Mecánica', 'Número de tareas de mecánica de vehículos pendiente check', strval($data[0]['mecanica'])];
            $value[] = ['Chapa', 'Número de tareas de chapa de vehiculos pendiente check.', strval($data[0]['chapa'])];

            return $value;

/*
        $year = $this->request->input('year') ?? date('Y');
        $data = GroupTask::with(['typeModelOrder'])
            ->filter($this->request->all())
            ->select(
                DB::raw('id'),
                DB::raw('approved'),
                DB::raw('vehicle_id'),
                DB::raw('count(vehicle_id) as total'),
                DB::raw('(SELECT type_model_order_id FROM vehicles WHERE id = group_tasks.vehicle_id) as type_model_order_id'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month')
            )
            ->whereRaw('id IN(SELECT MAX(id) FROM group_tasks GROUP BY vehicle_id)')
            ->whereRaw('YEAR(created_at) = ' . $year)
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->groupBy('type_model_order_id', 'year', 'month')
            ->get();

        $variable = [];
        foreach ($data as $key => $v) {
            if ($v['typeModelOrder']) {
                $a = $v['typeModelOrder']['name'];
                $variable[$a][(int) $v['month']] = $v['total'] ?? 0;    
            }
        }

        $value[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

        $value[0][0] = 'Año ' . $year;

        $value[] = ['Ckeck List', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];

        $value[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

        $value[] =  ['Ckeck List ', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nobiembre', 'Diciembre'];

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

        $data_now = GroupTask::with(['typeModelOrder'])
            ->filter($this->request->all())
            ->select(
                DB::raw('id'),
                DB::raw('approved'),
                DB::raw('vehicle_id'),
                DB::raw('created_at'),
                DB::raw('count(vehicle_id) as total'),
                DB::raw('(SELECT type_model_order_id FROM vehicles WHERE id = group_tasks.vehicle_id) as type_model_order_id'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') date"),
                DB::raw('YEAR(created_at) year'),
                DB::raw('MONTH(created_at) month'),
                DB::raw('DAY(created_at) day')
            )
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereRaw('id IN(SELECT MAX(id) FROM group_tasks GROUP BY vehicle_id)')
            ->whereRaw('YEAR(created_at) = ' . $year)
            ->whereRaw('MONTH(created_at) = ' . date('m'))
        //    ->whereRaw('DAY(created_at) = ' . (int) 9)
            ->groupBy('type_model_order_id', 'year', 'month', 'day')
            ->orderBy('day')
            ->get();

        $variable = [];
        $total = 0;
        foreach ($data_now as $key => $v) {
            $x = ($v['total'] ?? 0) - ($v['deleted'] ?? 0);
            $total = $total + $x;
            $variable[$v['typeModelOrder']['name'] . ' - ' . $v['day']][1] = $x;
        }

        $value[] = ['', '', '', '', ''];
        $value[] = ['', '', '', '', ''];

        $value[] =  ['Stock ' . date('m/Y'), 'Total', '%'];

        foreach ($variable as $key => $v) {
            $value[] = [
                $key,
                strval($v[1] ?? 0),
                strval($this->obtenerPorcentaje((int) $v[1] ?? 0, $total))
            ];
        }
        return $value;
*/
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
