<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->string('personnel_id')->nullable();
            $table->string('image')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('gender', ['female', 'male']);
            $table->enum('employment_type', ['fulltime', 'parttime', 'contract']);
            $table->enum('marital_status', ['married', 'single']);
            $table->integer('number_of_children')->nullable();
            $table->enum('employment_status', ['probational', 'working', 'terminated']);
            $table->string('id_card_number')->nullable();
            $table->string('id_booklet_number')->nullable();
            $table->enum('degree', ['undergraduate', 'graduate', 'postgraduate']);
            $table->string('field')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('landline')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('license_plate')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('address')->nullable();
            $table->text('accessibility')->nullable();
            $table->enum('department', ['MG', 'HR', 'MA', 'AS', 'CM', 'CP', 'AC', 'PS', 'WP', 'MK', 'CH', 'SP', 'CX', 'BD']);
            $table->enum('position', ['manager', 'supervisor', 'senior', 'expert', 'employee']);
            $table->string('insurance')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('emergency_relationship')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('work_experience')->nullable();
            $table->text('interests')->nullable();
            $table->string('favorite_colors')->nullable();
            $table->integer('user_id')->unsigned()->index();
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
        Schema::dropIfExists('profiles');
    }
}
