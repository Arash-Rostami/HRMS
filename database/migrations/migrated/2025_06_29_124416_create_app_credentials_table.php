<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_credentials', function (Blueprint $table) {
            Schema::create('app_credentials', function (Blueprint $table) {
                $table->increments('id')->unsigned()->index();
                $table->integer('user_id')->unsigned()->index();
                $table->string('app_name');
                $table->string('username');
                $table->string('password');
                $table->string('link')->nullable();
                $table->text('note')->nullable();
                $table->foreign('user_id')->references('id')->on('users');
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_credentials');
    }
}
