<?php

namespace App\Console\Commands;

use App\Mail\EntriesVehicles as MailEntriesVehicles;
use Faker\Core\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class EntriesVehicles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entry:vehicles';

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
    public function handle(MailEntriesVehicles $entriesVehicles)
    {
        /*$this->info(public_path());

        if(file_exists(public_path() . '/../storage/framework/laravel-excel/laravel-excel-4A0Xi8bGga0pwjyYMxtlOPVh0b25yWB5.xlsx')){
            $this->info('Existe');
        } else {
            $this->info('No existe');
        }*/
        // $this->info(Storage::exists('storage'));
        $entriesVehicles->build();
    }
}
