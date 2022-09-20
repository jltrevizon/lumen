<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeReceptionToReceptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receptions', function (Blueprint $table) {
            $table->unsignedBigInteger('type_reception_id')->after('vehicle_id')->nullable();
            $table->foreign('type_reception_id')->references('id')->on('type_receptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receptions', function (Blueprint $table) {
            $table->dropForeign('receptions_type_reception_id_foreign');
            $table->dropColumn('type_reception_id');
        });
    }
}
