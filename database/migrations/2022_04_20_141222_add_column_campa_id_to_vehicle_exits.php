<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCampaIdToVehicleExits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_exits', function (Blueprint $table) {
            $table->foreignId('campa_id')->after('vehicle_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_exits', function (Blueprint $table) {
            $table->dropForeign('vehicle_exits_campa_id_foreign');
            $table->dropColumn('campa_id');
        });
    }
}
