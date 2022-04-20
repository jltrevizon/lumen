<?php

namespace App\Exports;

use App\Models\DeliveryVehicle;
use App\Models\Reception;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DeliveryVehiclesExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct()
    {

    }

    public function collection()
    {
        return DeliveryVehicle::whereDate('created_at', date('Y-m-d'))
            ->get();
    }

    public function map($deliveryVehicle): array
    {
        $data = $deliveryVehicle->data_delivery;
        return [
            date('d-m-Y'),
            $deliveryVehicle->vehicle->typeModelOrder ? $deliveryVehicle->vehicle->typeModelOrder->name : null,
            $deliveryVehicle->vehicle ? $deliveryVehicle->vehicle->vin : null,
            $deliveryVehicle->vehicle ? $deliveryVehicle->vehicle->plate : null,
            $deliveryVehicle->vehicle->vehicleModel ? $deliveryVehicle->vehicle->vehicleModel->brand->name : null,
            $deliveryVehicle->vehicle->vehicleModel ?  $deliveryVehicle->vehicle->vehicleModel->name : null,
            $data['company'],
            $data['customer'],
            $data['driver'],
            $data['dni'],
            $data['truck'],
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
            'Transportista',
            'Cliente',
            'Conductor',
            'DNI',
            'Camión'
        ];
    }
}
