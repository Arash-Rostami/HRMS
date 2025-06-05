<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->string('employee_code')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('begin_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('leave_type');
            $table->string('begin_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('duration');
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
        Schema::dropIfExists('leaves');
    }
}
