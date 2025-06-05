<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->index();
            $table->string('usefulness');
            $table->string('length');
            $table->string('staff_insight');
            $table->string('product_insight');
            $table->string('info_insight');
            $table->string('it_insight');
            $table->string('interaction');
            $table->string('culture');
            $table->string('experience');
            $table->string('recommendation');
            $table->string('most_fav');
            $table->string('least_fav');
            $table->string('addition');
            $table->string('suggestion');
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
        Schema::dropIfExists('feedbacks');
    }
}
