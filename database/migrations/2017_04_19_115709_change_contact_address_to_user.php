<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeContactAddressToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_expresses', function (Blueprint $table) {
            $table->renameColumn('contact_address', 'contact_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_expresses', function (Blueprint $table) {
            $table->renameColumn('contact_user', 'contact_address');
        });
    }
}
