<?php

namespace App\Exports;

use App\Models\PendingTask;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KpiPendingTaskExport implements FromArray, WithHeadings
{
    protected $header = ['Tarea', 'Pendiente', 'En Curso', 'SUMATORIO'];
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array(): array
    {
        // $year = $this->request->input('year') ?? date('Y');
        $data_now = PendingTask::with(['task'])
            ->filter($this->request->all())
            ->select(
                DB::raw('id'),
                DB::raw('task_id'),
                DB::raw('state_pending_task_id'),
                DB::raw('COUNT(id) as total'),
                DB::raw('(SELECT type_model_order_id FROM vehicles WHERE id = pending_tasks.vehicle_id) as type_model_order_id')
            )
            ->whereRaw('reception_id IN(SELECT MAX(id) FROM receptions g GROUP BY vehicle_id)')
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
}
