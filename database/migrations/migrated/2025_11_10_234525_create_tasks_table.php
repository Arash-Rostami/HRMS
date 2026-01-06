<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id')->unsigned()->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['todo', 'in-progress', 'done'])->default('todo');
            $table->date('deadline')->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('assigned_to')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('assigned_to')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['user_id', 'assigned_to', 'status']);
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
