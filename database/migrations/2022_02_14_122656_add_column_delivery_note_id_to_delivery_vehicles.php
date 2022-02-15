<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDeliveryNoteIdToDeliveryVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_vehicles', function (Blueprint $table) {
            $table->foreignId('delivery_note_id')->after('campa_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_vehicles', function (Blueprint $table) {
            $table->dropForeign('delivery_vehicles_delivery_note_id_foreign');
            $table->dropColumn('delivery_note_id');
        });
    }
}
