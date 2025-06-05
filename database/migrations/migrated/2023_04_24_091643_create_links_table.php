<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->string('url');
            $table->string('url_title');
            $table->string('url_description')->nullable();
            $table->string('internal_url')->nullable();
            $table->string('image');
            $table->string('image_description')->nullable();
            $table->string('icon');
            $table->string('icon_description')->nullable();
            $table->enum('link', ['internal', 'external']);
            $table->string('sequence');
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
        Schema::dropIfExists('links');
    }
}
