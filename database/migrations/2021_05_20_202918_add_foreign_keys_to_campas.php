<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCampas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campas', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('province_id')->references('id')->on('provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campas', function (Blueprint $table) {
            $table->dropForeign('campas_company_id_foreign');
            $table->dropForeign('campas_province_foreign');
        });
    }
}
