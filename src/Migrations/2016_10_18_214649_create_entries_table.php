<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('origami_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid',12)->unique();
            $table->integer('module_id')->unsigned();
            $table->integer('position');
            $table->timestamps();
            
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
        Schema::dropIfExists('origami_entries');
    }
}
