<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->string('forename');
            $table->string('surname');
            $table->string('email')->unique();
            $table->text('open_password');
            $table->string('password');
            $table->mediumInteger('maximum')->default(12);
            $table->enum('type', ['employee', 'VIP', 'guest'])->default('employee');
            $table->enum('role', ['user', 'admin', 'developer'])->default('user');
            $table->enum('status', ['inactive', 'active', 'suspended'])->default('active');
            $table->enum('presence', ['onsite', 'off-site', 'on-leave'])->default('on-leave');
            $table->string('booking')->default('all');
            $table->rememberToken();
            $table->timestamp('last_seen')->nullable();
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
        Schema::dropIfExists('users');
    }
}
