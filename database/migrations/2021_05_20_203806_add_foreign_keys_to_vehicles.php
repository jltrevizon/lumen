<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->foreign('campa_id')->references('id')->on('campas');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('trade_state_id')->references('id')->on('trade_states');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign('vehicles_campa_id_foreign');
            $table->dropForeign('vehicles_category_id_foreign');
            $table->dropForeign('vehicles_state_id_foreign');
            $table->dropForeign('vehicles_trade_state_id_foreign');

        });
    }
}
