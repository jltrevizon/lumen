<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDeliveryNoteToVehicleExits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_exits', function (Blueprint $table) {
            $table->foreignId('delivery_note_id')->after('pending_task_id')->nullable()->constrained();
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
            $table->dropForeign('vehicle_exits_delivery_note_id_foreign');
            $table->dropColumn('delivery_note_id');
        });
    }
}
