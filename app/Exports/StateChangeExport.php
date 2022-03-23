<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\StateChange;
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
            $stateChange->vehicle->subState->state->name ?? null,
            $stateChange->vehicle->subState->name ?? null,
            $stateChange->campa->name ?? null,
            $stateChange->vehicle->typeModelOrder->name ?? null,
            $stateChange->created_at ? date('d-m-Y H:i:s', strtotime($stateChange->created_at ?? null)) : null,
            $stateChange->datetime_finish_sub_state ? date('d-m-Y H:i:s', strtotime($stateChange->datetime_finish_sub_state ?? null)) : null
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
            'Estado',
            'Sub-estado',
            'Campa',
            'Negocio',
            'Inicio sub-estado',
            'Fin sub-estado'
        ];
    }
}
