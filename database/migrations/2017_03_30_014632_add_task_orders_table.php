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
            $table->string('sn', 16);
            $table->integer('user_id');
            $table->string('user_name');
            $table->decimal('total_price', 10, 2);
            $table->decimal('real_price', 10, 2);
            $table->string('state');
            $table->string('pay_type');
            $table->string('pay_state');
            $table->string('deliver_type');
            $table->timestamps();
            $table->primary('sn');
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
