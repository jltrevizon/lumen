<?php

namespace App\Console\Commands;

use App\Exports\PendingTaskExport as ExportsPendingTaskExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class PendingTaskExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pendingtask:export';

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
        ini_set("memory_limit", "-1");
        $date = microtime(true);
        $array = explode('.', $date);
        if(env('APP_ENV') == 'production') {
            Excel::store(new ExportsPendingTaskExport, 'vehículos-tareas-realizadas-' . date('d-m-Y') . '-' . $array[0] . '.xlsx', 's3');
        }
    }
}
