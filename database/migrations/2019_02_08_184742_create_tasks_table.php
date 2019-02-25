<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_login',32);
            $table->string('task_name',100);
            $table->string('comments',100);
            $table->integer('hours');
            $table->integer('minutes');
            $table->string('day',10);   
            $table->timestampTz('updated_at');
            $table->timestampTz('created_at')->useCurrent()->default(DB::raw('CURRENT_TIMESTAMP'));         
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
