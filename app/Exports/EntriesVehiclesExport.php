<?php

namespace App\Exports;

use App\Models\Reception;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EntriesVehiclesExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct()
    {

    }

    public function collection()
    {
        return Reception::whereDate('created_at', date('Y-m-d'))
                ->get();
    }

    public function map($reception): array
    {
        return [
            date('d-m-Y'),
            $reception->vehicle->typeModelOrder ? $reception->vehicle->typeModelOrder->name : null,
            $reception->vehicle ? $reception->vehicle->vin : null,
            $reception->vehicle ? $reception->vehicle->plate : null,
            $reception->vehicle->vehicleModel ? $reception->vehicle->vehicleModel->brand->name : null,
            $reception->vehicle->vehicleModel ? $reception->vehicle->vehicleModel->name : null,
            $reception->campa ? $reception->campa->name : null,
            $reception->vehicle ? $reception->vehicle->version : null
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
