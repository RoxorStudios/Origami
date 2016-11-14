<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('origami_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid',12)->unique();
            $table->string('name')->nullable();
            $table->string('identifier')->unique();
            $table->boolean('list')->default(false);
            $table->text('options')->nullable();
            $table->boolean('only_admin')->default(false);
            $table->boolean('active')->default(true);
            $table->integer('sortable')->default(0);
            $table->integer('position')->default(0);
            $table->boolean('dashboard')->default(0);
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
        Schema::dropIfExists('origami_modules');
    }
}
