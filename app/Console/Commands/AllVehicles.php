<?php

namespace App\Console\Commands;

use App\Mail\AllVehiclesMail;
use Illuminate\Console\Command;

class AllVehicles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'all:vehicles';

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
    public function handle(AllVehiclesMail $allVehiclesMail)
    {
        $allVehiclesMail->build();
    }
}
