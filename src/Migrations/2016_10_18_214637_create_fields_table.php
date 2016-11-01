<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('origami_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid',12)->unique();
            $table->integer('module_id')->unsigned();
            $table->string('name');
            $table->string('identifier');
            $table->string('type');
            $table->string('description')->nullable();
            $table->boolean('required')->default(false);
            $table->json('options')->nullable();
            $table->integer('default')->default(false);
            $table->integer('position');
            $table->index('identifier');

            $table->foreign('module_id')->references('id')->on('origami_modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('origami_fields');
    }
}
