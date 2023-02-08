<?php

namespace App\Exports;

use App\Models\Reception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EntriesVehiclesExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Reception::filter($this->request->all())->get();
    }

    public function map($reception): array
    {
        Log::debug($reception);
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
