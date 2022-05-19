<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCampaToPeopleForReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('people_for_reports', function (Blueprint $table) {
            $table->foreignId('campa_id')->after('user_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('people_for_reports', function (Blueprint $table) {
            $table->dropForeign('people_for_reports_campa_id_foreign');
            $table->dropColumn('campa_id');
        });
    }
}
