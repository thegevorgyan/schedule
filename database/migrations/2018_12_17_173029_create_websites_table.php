<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('website_addr',100);
            $table->string('header',100);
            $table->text('text');
            $table->string('hint',100);
            $table->integer('age');
            $table->string('type',25);
            $table->string('key', 32);
            $table->string('filename',100);
            $table->string('bg_color',25);
            $table->string('verified_redirect_url',100);
            $table->string('reject_redirect_url',100);
            $table->string('enter_btn_text',25);
            $table->string('cancel_btn_text',25);
            $table->string('info_btn_text',25);
            $table->text('info_description');
            $table->integer('session_timeout');
            $table->text('terms_conditions');
            $table->string('username',25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('websites');
    }
}
