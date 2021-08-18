<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeBudgetLineIdToBudgetLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_lines', function (Blueprint $table) {
            $table->foreignId('type_budget_line_id')->after('id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_lines', function (Blueprint $table) {
            $table->dropForeign('budget_lines_type_budget_line_id_foreign');
            $table->dropColumn('type_budget_line_id');
        });
    }
}
