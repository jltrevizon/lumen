<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableIncidencePendingTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidence_pending_task', function (Blueprint $table) {
            $table->foreignId('incidence_id')->constrained()->onDelete('cascade');
            $table->foreignId('pending_task_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->primary(['incidence_id','pending_task_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_incidence_pending_task');
    }
}
