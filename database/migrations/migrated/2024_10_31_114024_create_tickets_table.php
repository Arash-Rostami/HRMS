<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('requester_id')->unsigned()->index();
            // Request Information
            $table->string('request_type');
            $table->string('request_area')->nullable();
            $table->string('request_subject');
            $table->text('description');
            $table->string('priority')->default('low')->nullable();
            $table->string('attachment')->nullable();
            // Completion and Responsibility Details
            $table->text('additional_notes')->nullable();
            $table->integer('assigned_to')->unsigned()->index()->nullable();
            $table->date('completion_deadline')->nullable();
            $table->date('completion_date')->nullable();
            $table->text('action_result')->nullable();
            // Status and Effectiveness
            $table->string('status')->default('open');
            $table->string('effectiveness')->nullable();
            $table->unsignedTinyInteger('satisfaction_score')->nullable();
            // Extra field for additional information
            $table->foreign('requester_id')->references('id')->on('users');
            $table->foreign('assigned_to')->references('id')->on('users');

            $table->json('requester_files')->nullable();
            $table->json('assignee_files')->nullable();
            $table->json('extra')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
