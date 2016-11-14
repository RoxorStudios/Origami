<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldIdToModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('origami_modules', function (Blueprint $table) {
            $table->integer('field_id')->unsigned()->nullable()->after('uid');
            $table->foreign('field_id')->references('id')->on('origami_fields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('origami_modules', function (Blueprint $table) {
            $table->dropForeign('origami_modules_field_id_foreign');
            $table->dropColumn('field_id');
        });
    }
}
