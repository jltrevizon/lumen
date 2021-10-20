<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAccessories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accessories', function (Blueprint $table) {
            $table->foreignId('reception_id')->nullable()->change();
            $table->foreignId('vehicle_id')->after('reception_id')->nullable()->constrained();
            $table->boolean('mounted')->after('description')->default(true);
            $table->dateTime('datetime_mounted')->after('mounted')->nullable();
            $table->dateTime('datetime_unmounted')->after('datetime_mounted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accessories', function (Blueprint $table) {
            $table->foreignId('reception_id')->nullable(false)->change();
            $table->dropForeign('accessories_vehicle_id_foreign');
            $table->dropColumn('vehicle_id');
            $table->dropColumn('mounted');
            $table->dropColumn('datetime_mounted');
            $table->dropColumn('datetime_unmounted');
        });
    }
}
