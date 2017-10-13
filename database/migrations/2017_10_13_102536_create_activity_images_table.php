<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_images', function (Blueprint $table) {
            $table->string('activity_no', 16);
            $table->integer('user_id')->comment('活动所属用户ID');
            $table->string('title')->comment('活动名称');
            $table->string('description')->default('')->comment('活动描述');
            $table->integer('public')->default('0')->comment('是否公开');
            $table->integer('click')->default('0')->comment('点击次数');
            $table->timestamps();
            $table->primary('activity_no');
            $table->string('link')->comment('外部链接地址');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_images');
    }
}
