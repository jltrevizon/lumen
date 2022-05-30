<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockVehiclesExport implements FromCollection, WithMapping, WithHeadings
{

    public function __construct($campaId)
    {
        $this->campaId = $campaId;
    }

    public function collection()
    {
        if($this->campaId == null) {
            return Vehicle::where('sub_state_id', '!=', SubState::ALQUILADO)
                ->get();
        } else {
            return Vehicle::where('campa_id', $this->campaId)
                    ->where('sub_state_id', '!=', SubState::ALQUILADO)
                    ->get();
        }
    }

    public function map($vehicle): array
    {
        return [
            $vehicle->plate,
            $vehicle->lastReception ? date('d/m/Y', strtotime($vehicle->lastReception->created_at ?? null)) : null,
            $vehicle->kms,
            $vehicle->vehicleModel->brand->name ?? null,
            $vehicle->vehicleModel->name ?? null,
            $vehicle->color->name ?? null,
            $vehicle->subState->state->name ?? null,
            $vehicle->subState->name ?? null,
            $vehicle->last_change_state ? date('d/m/Y H:i:s', strtotime($vehicle->last_change_state)) : null,
            $vehicle->last_change_sub_state ? date('d/m/Y H:i:s', strtotime($vehicle->last_change_sub_state)) : null,
            $vehicle->observations,
            $vehicle->accessoriesTypeAccessory->pluck('name')->implode(', ') ?? null,
            $vehicle->has_environment_label == true ? 'Si' : 'No',
            $vehicle->campa->name ?? null,
            '',
            $vehicle->next_itv ? date('d/m/Y', strtotime($vehicle->next_itv)) : null,
            $vehicle->category->name ?? null,
            $vehicle->typeModelOrder->name ?? null,
            $vehicle->lastGroupTask->lastPendingTaskWithState->task->name ?? null,
            $vehicle->lastGroupTask->lastPendingTaskWithState->statePendingTask->name ?? null,
            $vehicle->lastGroupTask?->lastPendingTaskWithState->datetime_start ? date('d/m/Y', strtotime($vehicle->lastGroupTask?->lastPendingTaskWithState->datetime_start)) : null,
            $vehicle->square ? ($vehicle->square->street->zone->name . ' ' . $vehicle->square->street->name . ' ' . $vehicle->square->name) : null,
            $vehicle->lastDeliveryVehicle ? ($vehicle->sub_state_id == SubState::ALQUILADO ? date('d/m/Y', strtotime($vehicle->lastDeliveryVehicle->created_at)) : null) : null,
            $vehicle->lastGroupTask->lastPendingTaskWithState->observations ?? null
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
            'Inicio estado',
            'Inicio sub-estado',
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
