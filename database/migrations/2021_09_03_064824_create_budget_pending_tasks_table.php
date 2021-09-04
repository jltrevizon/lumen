<?php

use App\Models\StateBudgetPendingTask;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetPendingTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_pending_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pending_task_id')->nullable()->constrained();
            $table->foreignId('state_budget_pending_task_id')->default(StateBudgetPendingTask::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_pending_tasks');
    }
}
