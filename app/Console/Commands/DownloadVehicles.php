<?php

namespace App\Console\Commands;

use App\Exports\VehiclesExport;
use App\Mail\DownloadVehicles as MailDownloadVehicles;
use App\Models\PendingDownload;
use App\Models\RequestDownload;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class DownloadVehicles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:vehicles';

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
    public function handle(MailDownloadVehicles $downloadVehicles)
    {
        $requestDownloads = PendingDownload::with(['user'])
                                        ->where('sended', false)
                                        ->where('type_document', 'vehicles')
                                        ->get();

        foreach($requestDownloads as $requestDownload){
            $downloadVehicles->sendFileVehicles($requestDownload);
        }
    }
}
