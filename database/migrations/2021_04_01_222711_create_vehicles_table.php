<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remote_id')->nullable();
            $table->foreignId('campa_id');
            $table->foreignId('category_id');
            $table->foreignId('state_id')->nullable();
            $table->string('ubication');
            $table->string('plate');
            $table->string('branch');
            $table->string('vehicle_model');
            $table->string('version')->nullable();
            $table->string('vin')->nullable();
            $table->date('first_plate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
