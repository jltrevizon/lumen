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
        if($this->campaId == null){
            return Reception::whereDate('created_at', date('Y-m-d'))
                    ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
                    ->get();
        } else {
            return Reception::whereDate('created_at', date('Y-m-d'))
                    ->where('campa_id', $this->campaId)
                    ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
                    ->get();
        }
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
