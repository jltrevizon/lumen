<?php

namespace App\Mail;

use App\Models\BudgetPendingTask;
use App\Models\PendingTask;
use App\Models\Reception;
use App\Models\VehiclePicture;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class StatisticsMail extends Mailable
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
        $firstChart = $this->receptionLastWeek();
        $chartByMonths = $this->receptionByMonths();
        $chartPendingTaskStart = $this->pendingTaskStart();
        $chartPendingTaskStartByMonths = $this->pendingTaskStartByMonths();
        $chartPendingTaskEnd = $this->pendingTaskEnd();
        $chartPendingTaskEndByMonths = $this->pendingTaskEndByMonths();
        $budgetPendingTask = $this->budgetsPendingTask();
        $chartBudgetPendingTaskByMonths = $this->budgetsPendingTaskByMonths();
        $chartImages = $this->images();
        $chartImagesByMonths = $this->imagesByMonths();
        $labels = $firstChart['labels'];
        $values = $firstChart['values'];
        $labelsChartByMonths = $chartByMonths['labels'];
        $valuesChartByMonths = $chartByMonths['values'];
        $labelsChartPendingTaskStart = $chartPendingTaskStart['labels'];
        $ValuesChartPendingTaskStart = $chartPendingTaskStart['values'];
        $labelChartPendingTaskStartByMonths = $chartPendingTaskStartByMonths['labels'];
        $valuesChartPendingTaskStartByMonths = $chartPendingTaskStartByMonths['values'];
        $labelsChartPendingTaskEnd = $chartPendingTaskEnd['labels'];
        $ValuesChartPendingTaskEnd = $chartPendingTaskEnd['values'];
        $labelsChartPendingTaskEndByMonths = $chartPendingTaskEndByMonths['labels'];
        $valuesChartPendingTaskEndByMonths = $chartPendingTaskEndByMonths['values'];
        $labelChartImages = $chartImages['labels'];
        $valueChartImages = $chartImages['values'];
        $labelBudgetPendingTask = $budgetPendingTask['labels'];
        $valueBudgetPendingTask = $budgetPendingTask['values'];
        $labelChartImagesByMonths = $chartImagesByMonths['labels'];
        $valuesChartImagesByMonths = $chartImagesByMonths['values'];
        $labelChartBudgetPendingTaskByMonths = $chartBudgetPendingTaskByMonths['labels'];
        $valuesChartBudgetPendingTaskByMonths = $chartBudgetPendingTaskByMonths['values'];

        $data = [ 
            'reception_by_days' => urlencode("{ type: 'bar', data: { labels: $labels, datasets: [{ label: 'Recepciones por día', data: $values, backgroundColor: getGradientFillHelper('vertical', ['#089A9F', '#08B9BF', '#0AE3EB']), }] } }"),
            'reception_by_months' => urlencode("{ type: 'bar', data: { labels: $labelsChartByMonths, datasets: [{ label: 'Recepciones por meses', data: $valuesChartByMonths, backgroundColor: getGradientFillHelper('vertical', ['#089A9F', '#08B9BF', '#0AE3EB']), }] } }"),
            'pending_tasks_by_days' => urlencode("{ type: 'bar', data: { labels: $labelsChartPendingTaskStart, datasets: [{ label: 'Tareas iniciadas en la última semana', data: $ValuesChartPendingTaskStart, backgroundColor: getGradientFillHelper('vertical', ['#089A9F', '#08B9BF', '#0AE3EB']), }] } }"),
            'pending_tasks_by_months' => urlencode("{ type: 'bar', data: { labels: $labelChartPendingTaskStartByMonths, datasets: [{ label: 'Tareas iniciadas en los últimos meses', data: $valuesChartPendingTaskStartByMonths, backgroundColor: getGradientFillHelper('vertical', ['#089A9F', '#08B9BF', '#0AE3EB']), }] } }"),
            'pending_tasks_end_by_days' => urlencode("{ type: 'bar', data: { labels: $labelsChartPendingTaskEnd, datasets: [{ label: 'Tareas finalizadas en la última semana', data: $ValuesChartPendingTaskEnd, backgroundColor: getGradientFillHelper('vertical', ['#089A9F', '#08B9BF', '#0AE3EB']), }] } }"),
            'pending_tasks_end_by_months' => urlencode("{ type: 'bar', data: { labels: $labelsChartPendingTaskEndByMonths, datasets: [{ label: 'Tareas finalizadas en los últimos meses', data: $valuesChartPendingTaskEndByMonths, backgroundColor: getGradientFillHelper('vertical', ['#089A9F', '#08B9BF', '#0AE3EB']), }] } }"),
            'images_by_days' => urlencode("{ type: 'bar', data: { labels: $labelChartImages, datasets: [{ label: 'Tareas finalizadas en los últimos meses', data: $valueChartImages, backgroundColor: getGradientFillHelper('vertical', ['#089A9F', '#08B9BF', '#0AE3EB']), }] } }"),
            'images_by_months' => urlencode("{ type: 'bar', data: { labels: $labelChartImagesByMonths, datasets: [{ label: 'Tareas finalizadas en los últimos meses', data: $valuesChartImagesByMonths, backgroundColor: getGradientFillHelper('vertical', ['#089A9F', '#08B9BF', '#0AE3EB']), }] } }"),
            'budget_pending_tasks_by_days' => urlencode("{ type: 'bar', data: { labels: $labelBudgetPendingTask, datasets: [{ label: 'Tareas finalizadas en los últimos meses', data: $valueBudgetPendingTask, backgroundColor: getGradientFillHelper('vertical', ['#089A9F', '#08B9BF', '#0AE3EB']), }] } }"),
            'budget_pending_tasks_by_months' => urlencode("{ type: 'bar', data: { labels: $labelChartBudgetPendingTaskByMonths, datasets: [{ label: 'Tareas finalizadas en los últimos meses', data: $valuesChartBudgetPendingTaskByMonths, backgroundColor: getGradientFillHelper('vertical', ['#089A9F', '#08B9BF', '#0AE3EB']), }] } }"),
            
        ];
        Mail::send('statistics', $data, function($message){
            $message->to('anelvin.mejia@grupomobius.com')->subject('Prueba de reporte');
            $message->from('inout@mkdautomotive.com', 'Focus');
        });
    }

    private function receptionLastWeek(){
        $days = 0;
        $labels = [];
        $values = [];
        while ($days <= 7) {
            $date = date("Y-m-d",strtotime(date('Y-m-d') . "- $days days"));
            $nonWorking = date('N', strtotime($date));
            if($nonWorking != 6 && $nonWorking != 7){
                $receptions = Reception::whereDate('created_at', $date)
                    ->get();
                array_push($labels, date("d-m-Y",strtotime(date('d-m-Y') . "- $days days")));
                array_push($values, count($receptions));
            }
            $days++;
        }
        $labels = array_reverse($labels);
        $values = array_reverse($values);
        return [
            'labels' => json_encode($labels),
            'values' => json_encode($values)
        ];
    }

    private function receptionByMonths(){
        $receptions = Reception::select(
            DB::raw('count(*) as total'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
        )
            ->groupBy('months')
            ->get();
        $labels = [];
        $values = [];
        foreach($receptions as $reception){
            array_push($labels, $reception['months']);
            array_push($values, $reception['total']);
        }
        return [
            'labels' => json_encode($labels),
            'values' => json_encode($values)
        ];
    }

    private function pendingTaskStart(){
        $days = 0;
        $labels = [];
        $values = [];
        while ($days <= 7) {
            $date = date("Y-m-d",strtotime(date('Y-m-d') . "- $days days"));
            $nonWorking = date('N', strtotime($date));
            if($nonWorking != 6 && $nonWorking != 7){
                $pendingTasks = PendingTask::whereDate('datetime_start', $date)
                    ->get();
                array_push($labels, date("d-m-Y",strtotime(date('d-m-Y') . "- $days days")));
                array_push($values, count($pendingTasks));
            }
            $days++;
        }
        $labels = array_reverse($labels);
        $values = array_reverse($values);
        return [
            'labels' => json_encode($labels),
            'values' => json_encode($values)
        ];
    }

    private function pendingTaskStartByMonths(){
        $pendingTasks = PendingTask::select(
            DB::raw('count(*) as total'),
            DB::raw("DATE_FORMAT(datetime_start,'%M %Y') as months"),
        )
            ->whereNotNull('datetime_start')
            ->groupBy('months')
            ->get();
        $labels = [];
        $values = [];
        foreach($pendingTasks as $pendingTask){
            array_push($labels, $pendingTask['months']);
            array_push($values, $pendingTask['total']);
        }
        return [
            'labels' => json_encode($labels),
            'values' => json_encode($values)
        ];
    }

    private function pendingTaskEnd(){
        $days = 0;
        $labels = [];
        $values = [];
        while ($days <= 7) {
            $date = date("Y-m-d",strtotime(date('Y-m-d') . "- $days days"));
            $nonWorking = date('N', strtotime($date));
            if($nonWorking != 6 && $nonWorking != 7){
                $pendingTasks = PendingTask::whereDate('datetime_finish', $date)
                    ->get();
                array_push($labels, date("d-m-Y",strtotime(date('d-m-Y') . "- $days days")));
                array_push($values, count($pendingTasks));
            }
            $days++;
        }
        $labels = array_reverse($labels);
        $values = array_reverse($values);
        return [
            'labels' => json_encode($labels),
            'values' => json_encode($values)
        ];
    }

    private function pendingTaskEndByMonths(){
        $pendingTasks = PendingTask::select(
            DB::raw('count(*) as total'),
            DB::raw("DATE_FORMAT(datetime_finish,'%M %Y') as months")
        )
            ->whereNotNull('datetime_finish')
            ->groupBy('months')
            ->get();
        $labels = [];
        $values = [];
        foreach($pendingTasks as $pendingTask){
            array_push($labels, $pendingTask['months']);
            array_push($values, $pendingTask['total']);
        }
        return [
            'labels' => json_encode($labels),
            'values' => json_encode($values)
        ];
    }

    private function images(){
        $days = 0;
        $labels = [];
        $values = [];
        while ($days <= 7) {
            $date = date("Y-m-d",strtotime(date('Y-m-d') . "- $days days"));
            $nonWorking = date('N', strtotime($date));
            if($nonWorking != 6 && $nonWorking != 7){
                $pendingTasks = VehiclePicture::whereDate('created_at', $date)
                    ->get();
                array_push($labels, date("d-m-Y",strtotime(date('d-m-Y') . "- $days days")));
                array_push($values, count($pendingTasks));
            }
            $days++;
        }
        $labels = array_reverse($labels);
        $values = array_reverse($values);
        return [
            'labels' => json_encode($labels),
            'values' => json_encode($values)
        ];
    }

    private function imagesByMonths(){
        $pendingTasks = VehiclePicture::select(
            DB::raw('count(*) as total'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
        )
            ->whereNotNull('created_at')
            ->groupBy('months')
            ->get();
        $labels = [];
        $values = [];
        foreach($pendingTasks as $pendingTask){
            array_push($labels, $pendingTask['months']);
            array_push($values, $pendingTask['total']);
        }
        return [
            'labels' => json_encode($labels),
            'values' => json_encode($values)
        ];
    }

    private function budgetsPendingTask(){
        $days = 0;
        $labels = [];
        $values = [];
        while ($days <= 7) {
            $date = date("Y-m-d",strtotime(date('Y-m-d') . "- $days days"));
            $nonWorking = date('N', strtotime($date));
            if($nonWorking != 6 && $nonWorking != 7){
                $pendingTasks = BudgetPendingTask::whereDate('created_at', $date)
                    ->get();
                array_push($labels, date("d-m-Y",strtotime(date('d-m-Y') . "- $days days")));
                array_push($values, count($pendingTasks));
            }
            $days++;
        }
        $labels = array_reverse($labels);
        $values = array_reverse($values);
        return [
            'labels' => json_encode($labels),
            'values' => json_encode($values)
        ];
    }
    
    private function budgetsPendingTaskByMonths(){
        $pendingTasks = BudgetPendingTask::select(
            DB::raw('count(*) as total'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
        )
            ->whereNotNull('created_at')
            ->groupBy('months')
            ->get();
        $labels = [];
        $values = [];
        foreach($pendingTasks as $pendingTask){
            array_push($labels, $pendingTask['months']);
            array_push($values, $pendingTask['total']);
        }
        return [
            'labels' => json_encode($labels),
            'values' => json_encode($values)
        ];
    }
}
