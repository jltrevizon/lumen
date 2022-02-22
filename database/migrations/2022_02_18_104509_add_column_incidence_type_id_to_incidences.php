<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIncidenceTypeIdToIncidences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incidences', function (Blueprint $table) {
            $table->foreignId('incidence_type_id')->after('vehicle_id')->nullable()->constrained();
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
            $table->dropForeign('incidences_incidence_type_id_foreign');
            $table->dropColumn('incidence_type_id');
        });
    }
}
