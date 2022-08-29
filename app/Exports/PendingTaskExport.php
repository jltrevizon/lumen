<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\PendingTask;
use App\Models\State;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        /*return Vehicle::with(['pendingTasks' => function ($query) {
            return $query->where('approved', true)->whereIn('state_pending_task_id', [StatePendingTask::IN_PROGRESS, StatePendingTask::FINISHED]);
        }])
            ->where('company_id', Company::ALD)
            ->get();*/
      //  $vehicle_ids = collect(Vehicle::filter([ 'defleetingAndDelivery' => 0 ])->get())->map(function ($item){ return $item->id;})->toArray();
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
                }
            ))
            ->where('approved', true)->whereIn('state_pending_task_id', [StatePendingTask::IN_PROGRESS, StatePendingTask::FINISHED])
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
       //     ->whereNotIn('vehicle_id', $vehicle_ids)
            ->get();
    }

    public function map($data): array
    {
        /*$array = [];
        if (count($vehicle->pendingTasks) > 0) {
            foreach ($vehicle->pendingTasks as $pendingTask) {
                $line = [
                    $vehicle->plate,
                    $pendingTask->reception ? date('d/m/Y', strtotime($pendingTask->reception->created_at)) : null,
                    $vehicle->kms,
                    $vehicle->vehicleModel->brand->name ?? null,
                    $vehicle->vehicleModel->name ?? null,
                    $vehicle->color->name ?? null,
                    $pendingTask->task->subState->state->name ?? null,
                    $pendingTask->task->subState->name ?? null,
                    $pendingTask->observations,
                    $vehicle->accessoriesTypeAccessory->pluck('name')->implode(', ') ?? null,
                    $vehicle->has_environment_label == true ? 'Si' : 'No',
                    $pendingTask->campa->name ?? null,
                    $vehicle->category->name ?? null,
                    $pendingTask->task->name ?? null,
                    $pendingTask->statePendingTask->name ?? null,
                    $pendingTask->datetime_start ? date('d/m/Y H:i:s', strtotime($pendingTask->datetime_start)) : null,
                    $pendingTask->datetime_finish ? date('d/m/Y H:i:s', strtotime($pendingTask->datetime_finish)) : null,
                    round(($pendingTask->total_paused / 60), 2),
                    $vehicle->typeModelOrder->name ?? null,
                    $vehicle->lastDeliveryVehicle?->created_at ? date('d/m/Y H:i:s', strtotime($vehicle->lastDeliveryVehicle->created_at)) : null,
                    $pendingTask->estimatedDates?->pluck('estimated_date')->implode(',') ?? null,
                ];
                array_push($array, $line);
            }
        } else {
            $line = [
                $vehicle->plate,
                $vehicle->lastReception ? date('d/m/Y', strtotime($vehicle->lastReception->created_at)) : null,
                $vehicle->kms,
                $vehicle->vehicleModel->brand->name ?? null,
                $vehicle->vehicleModel->name ?? null,
                $vehicle->color->name ?? null,
                $vehicle->subState->state->name ?? null,
                $vehicle->subState->name ?? null,
                null,
                $vehicle->accessoriesTypeAccessory->pluck('name')->implode(', ') ?? null,
                $vehicle->has_environment_label == true ? 'Si' : 'No',
                $vehicle->campa->name ?? null,
                $vehicle->category->name ?? null,
                $vehicle->task->name ?? null,
                null,
                null,
                null,
                null,
                $vehicle->typeModelOrder->name ?? null,
                $vehicle->lastDeliveryVehicle?->created_at ? date('d/m/Y H:i:s', strtotime($vehicle->lastDeliveryVehicle->created_at)) : null,
                null,
            ];
            array_push($array, $line);
        }

        return $array;*/
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
            'Tiempo (horas)',
            'Negocio',
            'última salida',
            'Fecha estimada'
        ];
    }
}
