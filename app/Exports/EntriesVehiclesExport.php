<?php

namespace App\Exports;

use App\Models\Reception;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EntriesVehiclesExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct($campaId)
    {
        $this->campaId = $campaId;
    }

    public function collection()
    {
        $params = array_merge([
            'whereHasVehicle' => 0,
            'subStatesNotIds' => [10]
        ], $this->campaId == null ? [] : [
            'campaIds' => [$this->campaId]
        ]);
        return Reception::whereDate('created_at', date('Y-m-d'))
            ->filter($params)
            ->get();
    }

    public function map($reception): array
    {
        return [
            date('d/m/Y'),
            $reception->vehicle->typeModelOrder->name ?? null,
            $reception->vehicle->vin ?? null,
            $reception->vehicle->plate ?? null,
            $reception->vehicle->vehicleModel->brand->name ?? null,
            $reception->vehicle->vehicleModel->name ?? null,
            $reception->campa->name ?? null,
            $reception->vehicle->version ?? null
        ];
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'cliente',
            'Chasis',
            'Matrícula',
            'Marca',
            'Modelo',
            'Campa',
            'Versión'
        ];
    }
}
