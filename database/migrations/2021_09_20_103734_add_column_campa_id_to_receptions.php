<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCampaIdToReceptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receptions', function (Blueprint $table) {
            $table->foreignId('campa_id')->nullable()->after('id')->constrained();
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
            $table->dropForeign('receptions_campa_id_foreign');
            $table->dropColumn('campa_id');
        });
    }
}
