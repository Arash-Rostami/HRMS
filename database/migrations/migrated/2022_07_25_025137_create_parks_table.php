<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parks', function (Blueprint $table) {
            $table->id();
            $table->text('number')->index();
            $table->text('start_date');
            $table->string('start_hour', 191);
            $table->text('end_date');
            $table->string('end_hour', 191);
            $table->enum('state', ['active', 'inactive']);
            $table->enum('soft_delete', ['true', 'false'])->default('false');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('spot_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('spot_id')->references('id')->on('spots');
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
        Schema::dropIfExists('parks');
    }
}
