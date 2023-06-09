<?php

namespace App\Console\Commands;

use App\Exports\StateChangeExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class StateChanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'state:change';

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
        $date = microtime(true);
        $array = explode('.', $date);
        Excel::store(new StateChangeExport, 'vehículos-cambios-sub-estados-' . date('d-m-Y'). '-' . $array[0] . '.xlsx', 's3');
    }
}
