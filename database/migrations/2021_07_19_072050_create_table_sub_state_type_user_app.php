<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSubStateTypeUserApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_state_type_user_app', function (Blueprint $table) {
            $table->foreignId('sub_state_id')->constrained()->onDelete('cascade');
            $table->foreignId('type_user_app_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->primary(['sub_state_id','type_user_app_id'], 'sub_state_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_state_type_user_app');
    }
}
