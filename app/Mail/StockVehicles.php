<?php

namespace App\Mail;

use App\Exports\DeliveryVehiclesExport;
use App\Exports\EntriesVehiclesExport;
use App\Exports\StockVehiclesExport;
use App\Models\Campa;
use App\Models\PeopleForReport;
use App\Models\Role;
use App\Models\SubState;
use App\Models\TypeReport;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class StockVehicles extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $campas = Campa::where('active', true)->get();

        foreach ($campas as $campa) {
            $request = request();
            $request->merge([
                'statesNotIds' => [4, 5, 10],
                'defleetingAndDelivery' => 1,
                'campaIds' => [$campa->id],
              //  'lastReceptionCreatedAtFrom' => Carbon::now('Europe/Madrid')->startOfDay()->timezone('UTC')->format('Y-m-d H:i:s'),
              //  'lastReceptionCreatedAtTo' => Carbon::now('Europe/Madrid')->endOfDay()->timezone('UTC')->format('Y-m-d H:i:s')
            ]);
            $peopleForReport = PeopleForReport::with(['user'])
                ->where('type_report_id', TypeReport::STOCK)
                ->where('campa_id', $campa->id)
                ->get();
            $data = [
                'title' => 'Stock de vehículos',
                'sub_title' => 'Adjunto se encuentra un documento con el stock de los vehículos al día ' . date('d/m/Y')
            ];

            $file = Excel::download(new StockVehiclesExport($request), 'entradas.xlsx')->getFile();
            rename($file->getRealPath(), $file->getPath() . '/' . 'stock-vehículos.xlsx');
            $fileRename1 = $file->getPath() . '/stock-vehículos.xlsx';

            $file = Excel::download(new EntriesVehiclesExport($campa->id), 'entradas.xlsx')->getFile();
            rename($file->getRealPath(), $file->getPath() . '/' . 'entries.xlsx');
            $fileRename2 = $file->getPath() . '/entries.xlsx';

            $file = Excel::download(new DeliveryVehiclesExport([
                'pendindTaskNull' => 0,
                'vehicleDeleted' => 0,
                'campaIds' => [$campa->id]
            ]), 'entradas.xlsx')->getFile();

            rename($file->getRealPath(), $file->getPath() . '/' . 'deliveries.xlsx');
            $fileRename3 = $file->getPath() . '/deliveries.xlsx';

            $attachments = [
                $fileRename1 => ['as' => 'Stock-vehículos.xlsx'],
                $fileRename2 => ['as' => 'Entradas.xlsx'],
                $fileRename3 => ['as' => 'Salidas.xlsx']
            ];

            foreach ($peopleForReport as $user) {
                if ($user['user']['role_id'] != Role::GLOBAL_MANAGER) {
                    Mail::send('report-generic', $data, function ($message) use ($user, $attachments) {
                        $message->to($user['user']['email'], $user['user']['name']);
                        $message->subject('Stock de vehículos');
                        $message->from('no-reply.focus@grupomobius.com', 'Focus');
                        foreach ($attachments as $filePath => $fileParameters) {
                            $message->attach($filePath, $fileParameters);
                        }
                    });
                }
            }
            \unlink($file->getPath() . '/stock-vehículos.xlsx');
            \unlink($file->getPath() . '/entries.xlsx');
            \unlink($file->getPath() . '/deliveries.xlsx');
        }

        $peopleForReport = PeopleForReport::with(['user'])
            ->where('type_report_id', TypeReport::STOCK)
            ->whereHas('user', function (Builder $builder) {
                return $builder->where('role_id', Role::GLOBAL_MANAGER);
            })
            ->get();
        
        $request2 = request();
        $request2->merge([
                'statesNotIds' => [4, 5, 10],
                'defleetingAndDelivery' => 1
              //  'lastReceptionCreatedAtFrom' => Carbon::now('Europe/Madrid')->startOfDay()->timezone('UTC')->format('Y-m-d H:i:s'),
              //  'lastReceptionCreatedAtTo' => Carbon::now('Europe/Madrid')->endOfDay()->timezone('UTC')->format('Y-m-d H:i:s')
        ]);
        $file = Excel::download(new StockVehiclesExport($request2), 'entradas.xlsx')->getFile();
        rename($file->getRealPath(), $file->getPath() . '/' . 'stock-vehículos.xlsx');
        $fileRename1 = $file->getPath() . '/stock-vehículos.xlsx';

        $file = Excel::download(new EntriesVehiclesExport(null), 'entradas.xlsx')->getFile();
        rename($file->getRealPath(), $file->getPath() . '/' . 'entries.xlsx');
        $fileRename2 = $file->getPath() . '/entries.xlsx';


        $file = Excel::download(new DeliveryVehiclesExport([
            'pendindTaskNull' => 0,
            'vehicleDeleted' => 0
        ]), 'entradas.xlsx')->getFile();

        rename($file->getRealPath(), $file->getPath() . '/' . 'deliveries.xlsx');
        $fileRename3 = $file->getPath() . '/deliveries.xlsx';

        $attachments = [
            $fileRename1 => ['as' => 'Stock-vehículos.xlsx'],
            $fileRename2 => ['as' => 'Entradas.xlsx'],
            $fileRename3 => ['as' => 'Salidas.xlsx']
        ];

        foreach ($peopleForReport as $user) {
            Mail::send('report-generic', $data, function ($message) use ($user, $attachments) {
                $message->to($user['user']['email'], $user['user']['name']);
                $message->subject('Stock de vehículos');
                $message->from('no-reply.focus@grupomobius.com', 'Focus');
                foreach ($attachments as $filePath => $fileParameters) {
                    $message->attach($filePath, $fileParameters);
                }
            });
        }
        \unlink($file->getPath() . '/stock-vehículos.xlsx');
        \unlink($file->getPath() . '/entries.xlsx');
        \unlink($file->getPath() . '/deliveries.xlsx');
    }
}
