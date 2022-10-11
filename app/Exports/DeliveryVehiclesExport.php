<?php

namespace App\Exports;

use App\Models\DeliveryVehicle;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DeliveryVehiclesExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct($params)
    {
        $this->params = $params;
    }

    public function collection()
    {
        return DeliveryVehicle::filter($this->params)->get();
    }

    public function map($deliveryVehicle): array
    {
        $data = json_decode($deliveryVehicle->data_delivery);
        return [
            $this->fixTime($deliveryVehicle->created_at),
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

    public function fixTime($date) {
        if ($date) {
            return (new  Carbon($date))->addHours(2)->format('d/m/Y H:m:i');
        }
        return $date;
    }

    public function headings(): array
    {
        return [
            'Entregado',
            'Campa',
            'Negocio',
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
