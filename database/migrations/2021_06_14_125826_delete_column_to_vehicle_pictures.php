<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnToVehiclePictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_pictures', function (Blueprint $table) {
            $table->dropForeign('vehicle_pictures_campa_id_foreign');
            $table->dropColumn('campa_id');
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
            $table->foreign('campa_id')->references('id')->on('campas');
        });
    }
}
