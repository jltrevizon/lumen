<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PendingTask;
use App\Models\Task;
use DateTime;

class SeeStatusPendingTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:pendingtask';

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
        $pending_tasks = PendingTask::where('state_pending_task_id', 2)
                    ->get();
        foreach($pending_tasks as $pending_task){
            $diff = $this->diffHours($pending_task['datetime_start'], date("Y-m-d H:i:s"));
            $task = Task::where('id', $pending_task['task_id'])
                        ->first();
            $update_pending_task = PendingTask::with(['incidences' => function ($query) {
                                                return $query->where('resolved', 0);
                                            }])
                                            ->where('id', $pending_task['id'])
                                            ->first();
            if($diff > $task->duration){
                $update_pending_task->status_color = 'Yellow';
                $update_pending_task->save();
            }
            if(count($update_pending_task['incidences']) > 0){
                $update_pending_task->status_color = 'Red';
                $update_pending_task->save();
            }
        }
    }

    public function diffHours($date1, $date2){
        $new_date1 = new DateTime($date1);
        $new_date2 = new DateTime($date2);
        $diff = $new_date1->diff($new_date2);
        return $diff->format('%H');
    }
}