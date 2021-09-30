<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDatetimeApprovedToGroupTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_tasks', function (Blueprint $table) {
            $table->dateTime('datetime_approved')->after('approved_available')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_tasks', function (Blueprint $table) {
            $table->dropColumn('datetime_approved');
        });
    }
}
