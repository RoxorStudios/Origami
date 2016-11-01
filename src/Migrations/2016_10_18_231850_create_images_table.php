<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('origami_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid',12)->unique();
            $table->integer('field_id')->unsigned()->nullable();
            $table->integer('data_id')->unsigned()->nullable();
            $table->text('filename')->nullable();
            $table->text('path')->nullable();
            $table->boolean('thumbnail')->default(0);
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->foreign('field_id')->references('id')->on('origami_fields')->onDelete('set null');
            $table->foreign('data_id')->references('id')->on('origami_data')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('origami_images');
    }
}
