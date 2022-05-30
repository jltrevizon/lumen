<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToSquares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('squares', function (Blueprint $table) {
            $table->foreignId('user_id')->after('vehicle_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('squares', function (Blueprint $table) {
            $table->dropForeign('squares_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
