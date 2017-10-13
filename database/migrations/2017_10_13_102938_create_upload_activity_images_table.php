<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadActivityImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_activity_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('所属用户ID');
            $table->string('link')->default('')->comment('链接');
            $table->string('key')->default('')->comment('key');
            $table->timestamps();
            $table->string('activity_no', 16)->default('');
            $table->string('title')->nullable()->default('')->comment('title');
            $table->string('description')->nullable()->default('')->comment('description');
            $table->integer('public')->default('0')->comment('是否公开');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_activity_images');
    }
}
