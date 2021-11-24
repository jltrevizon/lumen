<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignCommentToDamageImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('damage_images', function (Blueprint $table) {
            $table->foreignId('comment_id')->after('damage_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('damage_images', function (Blueprint $table) {
            $table->dropForeign('damage_images_comment_id_foreign');
            $table->dropColumn('comment_id');
        });
    }
}
