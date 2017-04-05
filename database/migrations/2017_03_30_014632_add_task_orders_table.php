<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaskOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_orders', function (Blueprint $table) {
			$table->string('out_trade_no', 16);
            $table->string('trade_name');
            $table->integer('user_id');
            $table->string('user_name');
            $table->integer('total_price');
            $table->integer('real_price');
            $table->string('state');
            $table->string('pay_type');
            $table->string('pay_state');
            $table->string('deliver_type');
            $table->timestamps();
            $table->primary('out_trade_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_orders');
    }
}
