<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
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
        return Vehicle::where('company_id', $this->companyId)
                    ->get();
    }

    public function map($vehicle): array
    {
        return [
            $vehicle->remote_id,
            $vehicle->company ? $vehicle->company->name : null,
            $vehicle->campa ? $vehicle->campa->name : null,
            $vehicle->plate,
            $vehicle->category ? $vehicle->category->name : null,
            $vehicle->subState ? $vehicle->subState->name : null,
            $vehicle->subState ? ($vehicle->subState->state ? $vehicle->subState->state->name : null) : null,
            $vehicle->ubication,
            $vehicle->vehicleModel ? $vehicle->vehicleModel->name : null,
            $vehicle->vehicleModel ? ($vehicle->VehicleModel->brand ? $vehicle->vehicleModel->brand->name : null) : null,
            $vehicle->kms,
            $vehicle->version,
            $vehicle->vin,
            $vehicle->first_plate,
            $vehicle->latitude,
            $vehicle->longitude
        ];
    }

    public function headings(): array
    {
        return [
            'REMOTE ID',
            'EMPRESA',
            'CAMPA',
            'MATRÍCULA',
            'CATEGORÍA',
            'SUB ESTADO',
            'ESTADO',
            'UBICACIÓN',
            'MODELO',
            'MARCA',
            'KILÓMETROS',
            'VERSIÓN',
            'VIN',
            'PRIMERA MATRÍCULA',
            'LATITUDE',
            'LONGITUDE'
        ];
    }
}
