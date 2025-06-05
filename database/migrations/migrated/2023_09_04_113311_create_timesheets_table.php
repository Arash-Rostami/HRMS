<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->string('employee_code')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('entry_time')->nullable();
            $table->string('exit_time')->nullable();
            $table->boolean('mission')->default(false);
            $table->enum('presence', ['onsite', 'off-site', 'on-leave']);
            $table->text('note')->nullable();
            $table->foreign('employee_code')->references('personnel_id')->on('profiles');
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
        Schema::dropIfExists('timesheets');
    }
}
