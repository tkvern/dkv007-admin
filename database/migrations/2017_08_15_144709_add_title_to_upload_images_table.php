<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleToUploadImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('upload_images', function (Blueprint $table) {
            $table->string('title')->nullable()->default('')->comment('title');
            $table->string('description')->nullable()->default('')->comment('description');
            $table->integer('public')->default('0')->comment('是否公开');
            $table->string('path')->default('')->comment('路径');
            $table->string('key')->default('')->comment('key');
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
            $table->dropColumn('title');
            $table->dropColumn('description');
            $table->dropColumn('public');
            $table->dropColumn('path');
            $table->dropColumn('key');
        });
    }
}
