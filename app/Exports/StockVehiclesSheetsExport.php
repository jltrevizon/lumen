<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StockVehiclesSheetsExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new VehiclesExport(10);
        $sheets[] = new VehiclesExport(15);
        $sheets[] = new VehiclesExport(5);
        
        return $sheets;
    }
}
