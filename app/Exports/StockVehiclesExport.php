<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class StockVehiclesExport implements FromCollection, WithMapping, WithHeadings
{

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $request = $this->request;
        return Vehicle::filter($request->all())->get();
    }

    public function map($vehicle): array
    {
        $approvedPendingTask = $vehicle->lastReception?->lastPendingTaskWithState;
        return [
            $vehicle->plate,
            $this->fixTime($vehicle->lastReception?->created_at),
            $vehicle->kms,
            $vehicle->vehicleModel->brand->name ?? null,
            $vehicle->vehicleModel->name ?? null,
            $vehicle->color->name ?? null,
            $vehicle->subState->state->name ?? null,
            $vehicle->subState->name ?? null,
            $this->fixTime($vehicle->last_change_state),
            $this->fixTime($vehicle->last_change_sub_state),
            $vehicle->observations,
            $vehicle->accessoriesTypeAccessory->pluck('name')->implode(', ') ?? null,
            $vehicle->has_environment_label == true ? 'Si' : 'No',
            $vehicle->campa->name ?? null,
            '',
            $this->fixTime($vehicle->next_itv ?? null),
            $vehicle->category->name ?? null,
            $vehicle->typeModelOrder->name ?? null,
            $approvedPendingTask?->task->name ?? null,
            $approvedPendingTask?->statePendingTask->name ?? null,
            $this->fixTime($approvedPendingTask?->datetime_start),
            $vehicle->square && $vehicle->square->street && $vehicle->square->street->zone ? ($vehicle->square->street->zone->name . ' ' . $vehicle->square->street->name . ' ' . $vehicle->square->name) : null,
            $approvedPendingTask?->observations ?? null
        ];
    }

    public function fixTime($date)
    {
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
            'Observaciones'
        ];
    }
}
