<?php

namespace App\Exports;

use App\Models\StatePendingTask;
use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VehiclesExport implements FromCollection, WithMapping, WithHeadings
{

    public function __construct(int $companyId)
    {
        $this->companyId = $companyId;
    }

    public function collection()
    {
        return Vehicle::with(['lastReception.pendingTasks' => function($query){
            return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS);
        }])
                    ->where('company_id', $this->companyId)
                    ->limit(2000)
                    ->get();
    }

    public function map($vehicle): array
    {
        return [
            $vehicle->plate,
            $vehicle->category->name ?? null,
            $vehicle->vehicleModel->brand->name ?? null,
            $vehicle->vehicleModel->name ?? null,
            $vehicle->typeModelOrder->name ?? null,
            $vehicle->kms,
            $vehicle->color->name ?? null,
            $vehicle->accessories->pluck('name')->implode(', ') ?? null,
            $vehicle->campa->name ?? null,
            $vehicle->lastReception ? date('d-m-Y', strtotime($vehicle->lastReception->created_at ?? null)) : null,
            $vehicle->subState->state->name ?? null,
            $vehicle->subState->name ?? null,
            $vehicle->lastReception->pendingTasks[0]->task->name ?? null,
            $vehicle->lastReception->pendingTasks[0]->statePendingTask->name ?? null,
            $vehicle->lastReception->pendingTasks[0]->start_datetime ?? null,
            $vehicle->square ? ($vehicle->square->street->zone->name . ' ' . $vehicle->square->street->name . ' ' . $vehicle->square->name) : null,
            $vehicle->lastDeliveryVehicle ? date('d-m-Y', strtotime($vehicle->lastDeliveryVehicle->created_at)) : null,
            $vehicle->lastReception->pendingTasks[0]->observations ?? null 
        ];
    }

    public function headings(): array
    {
        return [
            'Matrícula',
            'Categoría',
            'Marca',
            'Modelo',
            'Negocio',
            'Kilómetros',
            'Color',
            'Accesorios',
            'Campa',
            'Fecha de recepción',
            'Estado',
            'Sub-estado',
            'Tarea',
            'Estado',
            'Fecha Inicio Tarea',
            'Ubicación',
            'Fecha de Salida',
            'Observaciones'
        ];
    }
}
