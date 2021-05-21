<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVehiclePictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_pictures', function (Blueprint $table) {
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('campa_id')->references('id')->on('campas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_pictures', function (Blueprint $table) {
            $table->dropForeign('vehicle_pictures_vehicle_id_foreign');
            $table->dropForeign('vehicle_pictures_user_id_foreign');
            $table->dropForeign('vehicle_pictures_campa_id_foreign');
        });
    }
}
