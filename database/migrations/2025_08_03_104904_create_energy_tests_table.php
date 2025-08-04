<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnergyTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('energy_tests', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            // Pre-calculated scores for fast analytics and reporting
            $table->tinyInteger('mind_score')->index();
            $table->tinyInteger('emotion_score')->index();
            $table->tinyInteger('physique_score')->index();
            $table->tinyInteger('soul_score')->index();
            $table->tinyInteger('overall_score')->index();
            // Raw answers for detailed auditing and potential future analysis
            $table->json('answers');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('completed_at');
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
        Schema::dropIfExists('energy_tests');
    }
}
