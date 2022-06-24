<?php

namespace App\Exports;

use App\Models\PendingTask;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KpiPendingTaskExport implements FromArray, WithHeadings
{
    protected $header = ['Fecha de creación', 'Negocio', 'Tarea', 'Sin Estado', 'Pendiente', 'En Curso', 'Finalizada', 'Cancelada'];
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array(): array
    {
       // $year = $this->request->input('year') ?? date('Y');
        $data_now = PendingTask::with(['typeModelOrder', 'task'])
            ->filter($this->request->all())
            ->select(
                DB::raw('id'),
                DB::raw('task_id'),
                DB::raw('state_pending_task_id'),
                //  DB::raw('SUM(ISNULL(state_pending_task_id, 1)) as test'),
                DB::raw('COUNT(state_pending_task_id) as total'),
                DB::raw('(SELECT type_model_order_id FROM vehicles WHERE id = pending_tasks.vehicle_id) as type_model_order_id'),
                DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y') date"),
                DB::raw('YEAR(created_at) year'),
                DB::raw('MONTH(created_at) month'),
                DB::raw('DAY(created_at) day')
            )
         //   ->whereRaw('YEAR(created_at) = ' . $year)
         //   ->whereRaw('MONTH(created_at) = ' . date('m'))
            ->whereRaw('reception_id IN(SELECT MAX(id) FROM receptions r GROUP BY vehicle_id)')
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->groupBy('type_model_order_id', 'state_pending_task_id', 'year', 'month', 'day')
            ->orderBy('type_model_order_id')
            ->get();


        $variable = [];
        $total = 0;
        foreach ($data_now as $key => $v) {
            $x = ($v['total'] ?? 0);
            $total = $total + $x;
            $a = $v['typeModelOrder']['name'];
            $b = $v['task']['name'];
            $variable[$v['date']][($v['state_pending_task_id'] ?? 0) + 2] = $x;
            $variable[$v['date']][1] = $a;
            $variable[$v['date']][2] = $b;
        }

        foreach ($variable as $key => $v) {
            $value[] = [
                $key,
                strval($v[1] ?? 0),
                strval($v[2] ?? 0),
                strval($v[3] ?? 0),
                strval($v[4] ?? 0),
                strval($v[5] ?? 0),
                strval($v[6] ?? 0),
                strval($v[7] ?? 0)
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
