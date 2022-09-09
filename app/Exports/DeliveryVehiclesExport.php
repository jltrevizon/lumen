<?php

namespace App\Exports;

use App\Models\DeliveryVehicle;
use App\Models\Reception;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DeliveryVehiclesExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct($campaId)
    {   
        $this->campaId = $campaId;
    }

    public function collection()
    {
        if($this->campaId == null) {
            return DeliveryVehicle::whereDate('created_at', date('Y-m-d'))
                ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
                ->get();
        } else {
            return DeliveryVehicle::whereDate('created_at', date('Y-m-d'))
                ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
                ->where('campa_id', $this->campaId)
                ->get();
        }
    }

    public function map($deliveryVehicle): array
    {
        $data = json_decode($deliveryVehicle->data_delivery);
        return [
            date('d/m/Y'),
            $deliveryVehicle->campa->name ?? null,
            $deliveryVehicle->vehicle->typeModelOrder->name ?? null,
            $deliveryVehicle->vehicle->vin ?? null,
            $deliveryVehicle->vehicle->plate ?? null,
            $deliveryVehicle->vehicle->vehicleModel->brand->name ?? null,
            $deliveryVehicle->vehicle->vehicleModel->name ?? null,
            $data->company,
            $data->customer,
            $data->driver,
            $data->dni,
            $data->truck,
        ];
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Campa',
            'cliente',
            'Chasis',
            'Matrícula',
            'Marca',
            'Modelo',
            'Transportista',
            'Cliente',
            'Conductor',
            'DNI',
            'Camión'
        ];
    }
}
