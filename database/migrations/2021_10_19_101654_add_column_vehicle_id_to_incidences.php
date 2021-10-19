<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnVehicleIdToIncidences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incidences', function (Blueprint $table) {
            $table->foreignId('vehicle_id')->after('id')->nullable();
            $table->boolean('read')->after('description')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incidences', function (Blueprint $table) {
            $table->dropForeign('incidences_vehicle_id_foreign');
            $table->dropColumn('vehicle_id');
            $table->dropColumn('read');
        });
    }
}
