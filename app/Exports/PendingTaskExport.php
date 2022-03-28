<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\PendingTask;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PendingTaskExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PendingTask::whereHas('vehicle', function (Builder $builder){
            return $builder->where('company_id',Company::ALD);
        })
        ->get();
    }

    public function map($pendingTask): array
    {
        return [
            $pendingTask->vehicle->plate,
            $pendingTask->vehicle->lastReception ? date('d-m-Y', strtotime($pendingTask->vehicle->lastReception->created_at)) : null,
            $pendingTask->vehicle->kms,
            $pendingTask->vehicle->vehicleModel->brand->name ?? null,
            $pendingTask->vehicle->vehicleModel->name ?? null,
            $pendingTask->vehicle->color->name ?? null,
            $pendingTask->task->subState->state->name ?? null,
            $pendingTask->task->subState->name ?? null,
            $pendingTask->observations,
            $pendingTask->vehicle->accessoriesTypeAccessory->pluck('name')->implode(', ') ?? null,
            $pendingTask->vehicle->has_environment_label == true ? 'Si' : 'No',
            $pendingTask->vehicle->campa->name ?? null,
            $pendingTask->vehicle->category->name ?? null,
            $pendingTask->vehicle->task->name ?? null,
            $pendingTask->datetime_start,
            $pendingTask->datetime_finish,
            $pendingTask->total_paused,
            $pendingTask->vehicle->typeModelOrder->name ?? null
        ];
    }

    public function headings(): array
    {
        return [
            'Matrícula',
            'Fecha de recepción',
            'Kilómetros',
            'Marca',
            'Modelo',
            'Color',
            'Estado',
            'Sub-estado',
            'Observaciones',
            'Accesorios',
            'Etiqueta M.A.',
            'Campa',
            'Categoría',
            'Tarea',
            'Fecha inicio tarea',
            'Fecha fin tarea',
            'Tiempo (horas)',
            'Negocio',
        ];
    }
}
