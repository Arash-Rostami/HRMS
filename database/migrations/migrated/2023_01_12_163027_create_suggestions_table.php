<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->text('title');
            $table->longText('description');
            $table->json('department')->nullable();
            $table->json('purpose');
            $table->json('rule');
            $table->text('attachment')->nullable();
            $table->enum('stage', ['pending', 'team_remarks', 'dept_remarks', 'awaiting_decision', 'accepted',
                'rejected', 'under_review', 'closed'])->default('pending');
            $table->boolean('self_fill')->default(false);
            $table->enum('abort', ['yes', 'no'])->default('no');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->text('comments')->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }



    public function down()
    {
        Schema::dropIfExists('suggestions');
    }
}
