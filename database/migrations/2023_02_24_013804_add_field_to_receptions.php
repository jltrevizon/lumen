<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToReceptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receptions', function (Blueprint $table) {
            $table->string('plate')->nullable();
            $table->string('version')->nullable();
            $table->string('vin')->nullable();
            $table->integer('seater')->dafault(0);
            $table->integer('kms')->nullable();
            $table->boolean('priority')->default(0);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('ready_to_delivery')->default(false);
            $table->boolean('documentation')->default(true);
            $table->date('first_plate')->nullable();
            $table->string('color_id')->nullable();
            $table->unsignedBigInteger('deleted_user_id')->nullable();
            $table->boolean('has_environment_label')->nullable();
            $table->string('observations')->nullable();
            $table->dateTime('datetime_defleeting')->nullable();
            $table->date('next_itv')->nullable();

            $table->foreignId('remote_id')->nullable();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('vehicle_model_id')->nullable();
           
            $table->foreignId('company_id')->nullable()->constrained();
            $table->foreignId('trade_state_id')->nullable();
            $table->foreignId('sub_state_id')->nullable()->constrained();
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
            $table->dropColumn('plate');
            $table->dropColumn('version');
            $table->dropColumn('vin');
            $table->dropColumn('seater');
            $table->dropColumn('kms');
            $table->dropColumn('priority');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('ready_to_delivery');
            $table->dropColumn('documentation');
            $table->dropColumn('first_plate');
            $table->dropColumn('color_id');
            $table->dropColumn('deleted_user_id');
            $table->dropColumn('has_environment_label');
            $table->dropColumn('observations');
            $table->dropColumn('datetime_defleeting');
            $table->dropColumn('next_itv');
            
            $table->dropForeign('receptions_company_id_foreign');
            $table->dropColumn('company_id');

            $table->dropForeign('receptions_vehicle_model_id_foreign');
            $table->dropColumn('vehicle_model_id');

            $table->dropForeign('receptions_sub_state_id_foreign');
            $table->dropColumn('sub_state_id');

            $table->dropForeign('receptions_trade_state_id_foreign');
            $table->dropColumn('trade_state_id');

            $table->dropColumn('remote_id');
            $table->dropColumn('category_id');

        });
    }
}
