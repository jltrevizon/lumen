<?php

namespace App\Console\Commands;

use App\Models\PeopleForReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Exports\PendingTaskExport as ExportsPendingTaskExport;
use App\Exports\StockVehiclesExport;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\Types\Object_;

class ReportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $reports = PeopleForReport::with(['typeReport', 'campa'])
            ->whereNotNull('email')
            ->whereHas('typeReport', function ($query) {
                $query->whereRaw('JSON_CONTAINS(`schedule`, JSON_ARRAY("' . date('H') . ':00"))');
            })
            ->groupBy('type_report_id', 'campa_id', 'email')
            ->get();
        ini_set("memory_limit", "-1");
        $date = microtime(true);
        $array = explode('.', $date);
        $env = env('APP_ENV');
        $content = collect([]);
        foreach ($reports as $key => $report) {
            if ($content->where('email', $report->email)->count() === 0) {
                $content->push((object) [
                    'email' => $report->email,
                    'data' => collect([])
                ]);
            }
        }
        foreach ($reports as $key => $report) {
            Log::debug(StockVehiclesExport::class);
            switch ($report->typeReport->model_class) {
                case PendingTaskExport::class:
                    $request = request();
                    $request->merge([
                        'campasIds' => [$report->campa_id]
                    ]);
                    $slug = strtolower(trim(preg_replace('/[^A-Za-záéíóúÁÉÍÓÚñÑ0-9-]+/', '-', strtolower($report->typeReport->name . '-' . $report->campa->name))));
                    $file_name = $slug . '-' . date('d-m-Y') . '-' . $array[0] . '.xlsx';
                    $this->pushData($content, $report, $file_name);
                    Excel::store(new ExportsPendingTaskExport($request), $file_name, $env == 'production' ? 's3' : 'public');
                    break;
                case StockVehiclesExport::class:
                    $request = request();
                    $request->merge([
                        'statesNotIds' => [4, 5, 10],
                        'defleetingAndDelivery' => 1,
                        'campasIds' => [$report->campa_id]
                    ]);
                    $slug = strtolower(trim(preg_replace('/[^A-Za-záéíóúÁÉÍÓÚñÑ0-9-]+/', '-', strtolower($report->typeReport->name . '-' . $report->campa->name))));
                    $file_name = $slug . '-' . date('d-m-Y') . '-' . $array[0] . '.xlsx';
                    $this->pushData($content, $report, $file_name);
                    Excel::store(new StockVehiclesExport($request), $file_name, $env == 'production' ? 's3' : 'public');
                    break;
                default:
                    # code...
                    break;
            }
            Log::debug($content);
        }
    }

    function pushData(&$content, $report, $file_name)
    {
        $arr = $content->where('email', $report->email)->first();
        $arr->data->push((object) [
            'type_report_name' => $report->typeReport->name,
            'url' => env('AWS_URL') . '/' . $file_name,
            'campa_name' => $report->campa->name
        ]);
    }
}
