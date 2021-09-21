<?php

namespace App\Console\Commands;

use App\Mail\StockVehicles as MailStockVehicles;
use Illuminate\Console\Command;

class StockVehicles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:vehicles';

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
    public function handle(MailStockVehicles $stockVehicles)
    {
        $stockVehicles->build();
    }
}
