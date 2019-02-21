<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReceivedData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('remote_ip_addr',100);
            $table->string('website_addr',100);
            $table->string('key',32);
            $table->string('_token',32);
            $table->string('date',25);
            $table->string('verify',25);
            $table->longText('data');
            $table->timestampTz('added_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('received_data');
    }
}
