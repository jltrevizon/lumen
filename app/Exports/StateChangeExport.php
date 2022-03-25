<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\StateChange;
use App\Models\SubState;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StateChangeExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StateChange::whereHas('vehicle', function (Builder $builder){
            return $builder->where('company_id', Company::ALD);
        })
        ->get();
    }

    public function map($stateChange): array 
    {
        return [
            $stateChange->vehicle->plate,
            $stateChange->vehicle->lastReception ? date('d-m-Y', strtotime($stateChange->vehicle->lastReception->created_at ?? null)): null,
            $stateChange->vehicle->kms,
            $stateChange->vehicle->vehicleModel->brand->name ?? null,
            $stateChange->vehicle->vehicleModel->name ?? null,
            $stateChange->vehicle->color->name ?? null,
            $stateChange->vehicle->subState->state->name ?? null,
            $stateChange->vehicle->subState->name ?? null,
            $stateChange->vehicle->obervations,
            $stateChange->vehicle->accessories->pluck('name')->implode(', ') ?? null,
            $stateChange->vehicle->has_environment_label == true ? 'Si' : 'No',
            $stateChange->campa->name ?? null,
            '',
            $stateChange->vehicle->category->name ?? null,
            $stateChange->pendingTak->task->name ?? null,
            $stateChange->square->street->zone->name ?? null,
            $stateChange->square->street->name ?? null,
            $stateChange->square->name ?? null,
            $stateChange->vehicle->typeModelOrder->name ?? null,
            $stateChange->created_at ? date('d-m-Y H:i:s', strtotime($stateChange->created_at ?? null)) : null,
            $stateChange->datetime_finish_sub_state ? date('d-m-Y H:i:s', strtotime($stateChange->datetime_finish_sub_state ?? null)) : null,
            $stateChange->total_time ? round($stateChange->total_time / 60, 2) : null,
            $stateChange->vehicle->lastDeliveryVehicle ? ($stateChange->vehicle->sub_state_id == SubState::ALQUILADO ? date('d-m-Y', strtotime($stateChange->vehicle->lastDeliveryVehicle->created_at)) : null) : null,
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
            'color',
            'Estado',
            'Sub-estado',
            'Observaciones',
            'Accesorios',
            'Etiqueta M.A.',
            'Campa',
            'Próxima ITV',
            'Categoría',
            'Tarea',
            'Zona',
            'Calle',
            'Plaza',
            'Negocio',
            'Inicio sub-estado',
            'Fin sub-estado',
            'Tiempo (horas)',
            'Fecha de salida'
        ];
    }
}
