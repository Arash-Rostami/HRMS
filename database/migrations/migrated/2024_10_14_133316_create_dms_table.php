<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dms', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->string('file');
            $table->string('code');
            $table->string('version');
            $table->string('title');
            $table->enum('status', ['live', 'under_review', 'obsolete']);
            $table->json('owners');
            $table->text('revision')->nullable();
            $table->integer('combined_read_count')->default(0);
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
        Schema::dropIfExists('d_m_s');
    }
}
