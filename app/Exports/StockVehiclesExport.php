<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockVehiclesExport implements FromCollection, WithMapping, WithHeadings
{

    public function __construct()
    {

    }

    public function collection()
    {
        return Vehicle::where('company_id', Company::ALD)
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
            $vehicle->lastGroupTask->pendingTasks[0]->task->name ?? null,
            $vehicle->lastGroupTask->pendingTasks[0]->statePendingTask->name ?? null,
            $vehicle->lastGroupTask->pendingTasks[0]->start_datetime ?? null,
            $vehicle->square ? ($vehicle->square->street->zone->name . ' ' . $vehicle->square->street->name . ' ' . $vehicle->square->name) : null,
            $vehicle->lastDeliveryVehicle ? date('d-m-Y', strtotime($vehicle->lastDeliveryVehicle->created_at)) : null,
            $vehicle->lastGroupTask->pendingTasks[0]->observations ?? null
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
