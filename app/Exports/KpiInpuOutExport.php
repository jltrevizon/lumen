<?php

namespace App\Exports;

use stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\StatePendingTask;
use App\Views\KpiView;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Fromarray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KpiInpuOutExport implements FromCollection, WithMapping, WithHeadings
{    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $in_data = KpiView::with(['typeModelOrder'])
            ->filter($this->request->all())
            ->select(
                DB::raw('count(in_kpi) as `total`'), 
                DB::raw('view_kpis.type_model_order_id'),
                DB::raw('view_kpis.in_month')
            )
            ->groupBy('type_model_order_id', 'in_kpi' , 'in_month')
            ->get();
        $out_data = KpiView::with(['typeModelOrder'])
            ->filter($this->request->all())
            ->select(
                DB::raw('count(out_kpi) as `total`'), 
                DB::raw('view_kpis.type_model_order_id'),
                DB::raw('view_kpis.out_month')
            )
            ->groupBy('type_model_order_id', 'out_kpi' ,'out_month')
            ->get();
        return KpiView::all();
    }

    public function map($data): array
    {
        return [
            $data->id
        ];
        /*return [
           'Bipi', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
        ];*/
    }

    public function headings(): array
    {
        return [
            'ID'
        ];
        return [
           'Negocio',
           'Enero',
           'Febrero',
           'Marzo',
           'Abril',
           'Mayo',
           'Junio',
           'Julio',
           'Agosto',
           'Septiembre',
           'Optubre',
           'Noviembre',
           'Diciembre'
        ];
    }
}
