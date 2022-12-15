<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceptionIdToDamageHistoryLocationVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('damages', function (Blueprint $table) {
            $table->unsignedBigInteger('reception_id')->after('id')->nullable();
            $table->foreign('reception_id')->references('id')->on('receptions');
        });
        Schema::table('history_locations', function (Blueprint $table) {
            $table->unsignedBigInteger('reception_id')->after('id')->nullable();
            $table->foreign('reception_id')->references('id')->on('receptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('damage_history_location_vehicles', function (Blueprint $table) {
            //
        });
    }
}
