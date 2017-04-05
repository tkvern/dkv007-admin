<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableUserTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('任务所属用户ID');
            $table->string('user_name')->comment('任务所属公司名称或者个人姓名');
            $table->string('name')->comment('任务名称');
            $table->string('local_dir')->comment('任务对应的本地目录, 断点续传时使用');
            $table->string('handle_params')->comment('任务处理参数');
            $table->string('storage_address')->default('')->comment('云端存储位置');
            $table->string('deliver_type')->comment('上传方式');
            $table->string('download_link')->default('')->comment('下载链接');
            $table->string('handle_state')->comment('任务处理状态');
            $table->string('order_no')->comment('订单号');
            $table->string('pay_state')->comment('支付状态');
            $table->integer('price')->default(0)->comment('任务处理计算价格, 单位分');
            $table->integer('real_price')->default(0)->comment('任务处理实际价格, 单位分');
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
        Schema::dropIfExists('tasks');
    }
}
