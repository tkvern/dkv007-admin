<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('account_type');
            $table->string('name');
            $table->string('phone_number');
            $table->string('country');
            $table->string('region');
            $table->string('contact_address');
            $table->rememberToken();
            $table->string('login_ip')->nullable();
            $table->timestamp('login_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE users AUTO_INCREMENT = 1000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
