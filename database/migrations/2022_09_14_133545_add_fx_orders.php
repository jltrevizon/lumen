<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFxOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->integer("id_gsp")->nullable()->change();
            $table->integer("id_gsp_peritacion")->nullable()->after("id_gsp");
            $table->integer("id_gsp_certificado")->nullable()->after("id_gsp_peritacion");
            $table->dateTime('fx_entrada')->after('id_gsp_peritacion')->nullable();
            $table->dateTime('fx_fallo_check')->after('fx_entrada')->nullable();
            $table->dateTime('fx_first_budget')->after('fx_fallo_check')->nullable();
            $table->dateTime('fx_prevista_reparacion')->after('fx_first_budget')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('id_gsp');
            $table->dropColumn('id_gsp_peritacion');
            $table->dropColumn('id_gsp_certificado');
            $table->dropColumn('fx_entrada');
            $table->dropColumn('fx_fallo_check');
            $table->dropColumn('fx_first_budget');
            $table->dropColumn('fx_prevista_reparacion');
        });
    }
}
