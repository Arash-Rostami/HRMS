<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id()->unsigned()->index();
            $table->longText('comments')->nullable();
            $table->longText('actions')->nullable();
            $table->enum('feedback', ['agree', 'neutral', 'disagree', 'incomplete', 'unknown']);
            $table->enum('department', ['HR', 'MA', 'AS', 'CM', 'CP', 'AC', 'PS', 'WP', 'MK', 'CH',
                'SP', 'CX', 'BD', 'PERSORE'])->nullable();
            $table->enum('complete', ['yes', 'no'])->default('no');
            $table->json('referral')->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('suggestion_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('suggestion_id')->references('id')->on('suggestions');
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
        Schema::dropIfExists('reviews');
    }
}
