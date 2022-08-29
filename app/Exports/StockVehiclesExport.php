<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

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
                ->filter([ 'defleetingAndDelivery' => 1 ])
                ->get();
        } else {
            return Vehicle::where('campa_id', $this->campaId)
                    ->where('sub_state_id', '!=', SubState::ALQUILADO)
                    ->filter([ 'defleetingAndDelivery' => 1 ])
                    ->get();
        }
    }

    public function map($vehicle): array
    {
        $pendingTask = $vehicle->lastGroupTask?->lastPendingTaskWithState;
        return [
            $vehicle->plate,
            $vehicle->lastReception ? $this->fixTime($vehicle->lastReception->created_at ?? null) : null,
            $vehicle->kms,
            $vehicle->vehicleModel->brand->name ?? null,
            $vehicle->vehicleModel->name ?? null,
            $vehicle->color->name ?? null,
            $vehicle->subState->state->name ?? null,
            $vehicle->subState->name ?? null,
            $pendingTask?->last_change_state ? $this->fixTime($vehicle->last_change_state) : null,
            $pendingTask?->last_change_sub_state ? $this->fixTime($vehicle->last_change_sub_state) : null,
            $vehicle->observations,
            $vehicle->accessoriesTypeAccessory->pluck('name')->implode(', ') ?? null,
            $vehicle->has_environment_label == true ? 'Si' : 'No',
            $vehicle->campa->name ?? null,
            '',
            $vehicle->next_itv ? $this->fixTime($vehicle->next_itv ?? null) : null,
            $vehicle->category->name ?? null,
            $vehicle->typeModelOrder->name ?? null,
            $pendingTask->task->name ?? null,
            $pendingTask->statePendingTask->name ?? null,
            $pendingTask?->datetime_start ? $this->fixTime($vehicle->lastGroupTask?->lastPendingTaskWithState->datetime_start ?? null) : null,
            $vehicle->square && $vehicle->square->street && $vehicle->square->street->zone ? ($vehicle->square->street->zone->name . ' ' . $vehicle->square->street->name . ' ' . $vehicle->square->name) : null,
            // $vehicle->lastDeliveryVehicle ? ($vehicle->sub_state_id == SubState::ALQUILADO ? date('d/m/Y', strtotime($this->fixTime($vehicle->lastDeliveryVehicle->created_at ?? null))) : null) : null,
            $pendingTask?->observations ?? null
        ];
    }

    public function fixTime($date) {
        if ($date) {
            return (new  Carbon($date))->addHours(2)->format('d/m/Y H:m:i');
        }
        return $date;
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
            // 'Fecha de Salida',
            'Observaciones'
        ];
    }
}
