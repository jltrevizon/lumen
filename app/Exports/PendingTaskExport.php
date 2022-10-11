<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\PendingTask;
use App\Models\StatePendingTask;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PendingTaskExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PendingTask::select(['datetime_start', 'datetime_finish', 'observations', 'vehicle_id', 'task_id', 'total_paused', 'reception_id'])
            ->selectRaw(DB::raw('(select sp.name from state_pending_tasks sp where sp.id = pending_tasks.state_pending_task_id) as state_pending_task_name'))
            ->selectRaw(DB::raw('(select c.name from campas c where c.id = pending_tasks.campa_id) as campa_name'))
            ->with(array(
                'vehicle' => function ($query) {
                    $query->select(['id', 'plate', 'kms', 'has_environment_label', 'company_id', 'vehicle_model_id'])
                        ->selectRaw(DB::raw('(select c.name from colors c where c.id = vehicles.color_id) as color_name'))
                        ->selectRaw(DB::raw('(select c.name from categories c where c.id = vehicles.category_id) as category_name'))
                        ->selectRaw(DB::raw('(SELECT GROUP_CONCAT((SELECT a.name from accessories a where a.id = av.accessory_id)) as accesory_name from accessory_vehicle av where av.vehicle_id = vehicles.id group By av.vehicle_id) as accesory_name'))
                        ->with([
                            'vehicleModel' => function ($q) {
                                $q->select('id', 'name', 'brand_id')
                                    ->selectRaw(DB::raw('(select b.name from brands b where b.id = vehicle_models.brand_id) as brand_name'));
                            }
                        ])
                        ->where('company_id', Company::ALD);
                },
                'task' => function ($query) {
                    $query->select(['id', 'name', 'sub_state_id'])
                        ->with(array(
                            'subState' => function ($q) {
                                $q->select('id', 'name', 'state_id')->with(['state' => function ($q) {
                                    $q->select('id', 'name');
                                }]);
                            }
                        ));
                },
                'reception' => function($q) {
                    $q->select('id', 'created_at', 'type_model_order_id')
                    ->with([
                        'typeModelOrder' => function($query) {
                            $query->select('id', 'name');
                        }
                    ]);
                },
                'userStart' => function ($query) {
                    $query->select('id', 'name');
                },
                'userEnd' => function ($query) {
                    $query->select('id', 'name');
                },
            ))
            ->whereNotNull('reception_id')
            ->where('approved', true)->whereIn('state_pending_task_id', [StatePendingTask::IN_PROGRESS, StatePendingTask::FINISHED])
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
       //     ->whereNotIn('vehicle_id', $vehicle_ids)
            ->get();
    }

    public function map($data): array
    {
        $array = [];
        $line = [];
        if ($data->vehicle) {
            $line = [
                $data->vehicle->plate,
                $data->reception ? date('d/m/Y', strtotime($data->reception->created_at)) : null,
                $data->vehicle->kms,
                $data->vehicle->vehicleModel->brand->name ?? null,
                $data->vehicle->vehicleModel->name ?? null,
                $data->vehicle->color_name ?? null,
                $data->task->subState->state->name ?? null,
                $data->task->subState->name ?? null,
                $data->observations,
                $data->vehicle->accesory_name ?? null,
                $data->vehicle->has_environment_label == true ? 'Si' : 'No',
                $data->campa_name ?? null,
                $data->vehicle->category_name ?? null,
                $data->task->name ?? null,
                $data->state_pending_task_name,
                $data->datetime_start ? date('d/m/Y H:i:s', strtotime($data->datetime_start)) : null,
                $data->datetime_finish ? date('d/m/Y H:i:s', strtotime($data->datetime_finish)) : null,
                $data->user_start?->name ?? null,
                $data->user_end?->name ?? null,
                round(($data->total_paused / 60), 2),
                $data->reception?->typeModelOrder?->name,
                $data->vehicle->lastDeliveryVehicle?->created_at ? date('d/m/Y H:i:s', strtotime($data->vehicle->lastDeliveryVehicle->created_at)) : null,
                $data->estimatedDates?->pluck('estimated_date')->implode(',') ?? null,
            ];
            array_push($array, $line);
        }
        return $array;
    }

    public function headings(): array
    {
        return [
            'Matrícula',
            'Fecha de recepción',
            'Kilómetros',
            'Marca',
            'Modelo',
            'Color',
            'Estado',
            'Sub-estado',
            'Observaciones',
            'Accesorios',
            'Etiqueta M.A.',
            'Campa',
            'Categoría',
            'Tarea',
            'Estado tarea',
            'Fecha inicio tarea',
            'Fecha fin tarea',
            'Operario Inicio la Tarea',
            'Operario Finalizo la Tarea',
            'Tiempo (horas)',
            'Negocio',
            'última salida',
            'Fecha estimada'
        ];
    }
}
