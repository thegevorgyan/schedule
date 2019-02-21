<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoredDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('stored_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('remote_ip_addr',32);
            $table->string('key',32);
            $table->string('_token',32);
            $table->longtext('_cookies');
            $table->timestampTz('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stored_data');
    }
}
