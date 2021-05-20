<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('state_request_id')->references('id')->on('state_requests');
            $table->foreign('type_request_id')->references('id')->on('type_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign('requests_customer_id_foreign');
            $table->dropForeign('requests_vehicle_id_foreign');
            $table->dropForeign('requests_state_request_id_foreign');
            $table->dropForeign('requests_type_request_id_foreign');

        });
    }
}
