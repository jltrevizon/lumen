<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
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
                ->whereHas('campa')
                ->where('sub_state_id', '!=', SubState::ALQUILADO)
                ->get();
    }

    public function map($vehicle): array
    {
        return [
            $vehicle->plate,
            $vehicle->lastReception ? date('d-m-Y', strtotime($vehicle->lastReception->created_at ?? null)) : null,
            $vehicle->kms,
            $vehicle->vehicleModel->brand->name ?? null,
            $vehicle->vehicleModel->name ?? null,
            $vehicle->color->name ?? null,
            $vehicle->subState->state->name ?? null,
            $vehicle->subState->name ?? null,
            $vehicle->observations,
            $vehicle->accessories->pluck('name')->implode(', ') ?? null,
            $vehicle->has_environment_label == true ? 'Si' : 'No',
            $vehicle->campa->name ?? null,
            '',
            '',
            $vehicle->category->name ?? null,
            $vehicle->typeModelOrder->name ?? null,
            $vehicle->lastGroupTask->pendingTasks[0]->task->name ?? null,
            $vehicle->lastGroupTask->pendingTasks[0]->statePendingTask->name ?? null,
            $vehicle->lastGroupTask->pendingTasks[0]->start_datetime ?? null,
            $vehicle->square ? ($vehicle->square->street->zone->name . ' ' . $vehicle->square->street->name . ' ' . $vehicle->square->name) : null,
            $vehicle->lastDeliveryVehicle ? ($vehicle->sub_state_id == SubState::ALQUILADO ? date('d-m-Y', strtotime($vehicle->lastDeliveryVehicle->created_at)) : null) : null,
            $vehicle->lastGroupTask->pendingTasks[0]->observations ?? null
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
            'Código campa',
            'Próxima ITV',
            'Categoría',
            'Negocio',
            'Tarea',
            'Estado',
            'Fecha Inicio Tarea',
            'Ubicación',
            'Fecha de Salida',
            'Observaciones'
        ];
    }
}
