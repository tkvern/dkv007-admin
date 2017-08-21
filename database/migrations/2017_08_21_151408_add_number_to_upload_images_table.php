<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumberToUploadImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('upload_images', function (Blueprint $table) {
            $table->string('activity_no', 16)->default('');
            $table->integer('number')->default('1')->comment('序号');
            $table->integer('size_no')->default('8')->comment('分辨率');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('upload_images', function (Blueprint $table) {
            $table->dropColumn('activity_no');
            $table->dropColumn('number');
            $table->dropColumn('size_no');
        });
    }
}
