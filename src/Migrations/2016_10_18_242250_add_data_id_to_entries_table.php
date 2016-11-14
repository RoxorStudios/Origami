<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataIdToEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('origami_entries', function (Blueprint $table) {
            $table->integer('data_id')->unsigned()->nullable()->after('module_id');
            $table->foreign('data_id')->references('id')->on('origami_data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('origami_entries', function (Blueprint $table) {
            $table->dropForeign('origami_entries_data_id_foreign');
            $table->dropColumn('data_id');
        });
    }
}
