<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('province_id')->nullable();
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('campas');
    }
}
