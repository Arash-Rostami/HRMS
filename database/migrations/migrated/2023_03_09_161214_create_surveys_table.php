<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->index();
            $table->enum('days',['30','60','90']);
            $table->string('resource');
            $table->string('team');
            $table->string('manager');
            $table->string('company');
            $table->string('join');
            $table->string('newcomer');
            $table->string('buddy');
            $table->longText('role');
            $table->longText('challenge');
            $table->longText('stage');
            $table->longText('improvement');
            $table->longText('suggestion');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('surveys');
    }
}
