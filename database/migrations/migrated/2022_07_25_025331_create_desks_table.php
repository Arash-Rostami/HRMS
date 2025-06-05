<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desks', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unsigned()->index();
            $table->text('start_date');
            $table->string('start_hour', 191);
            $table->text('end_date');
            $table->string('end_hour', 191);
            $table->enum('state', ['active', 'inactive']);
            $table->enum('soft_delete', ['true', 'false'])->default('false');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('seat_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('seat_id')->references('id')->on('seats');
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
        Schema::dropIfExists('desks');
    }
}
