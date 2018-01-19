<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCarsTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
            $table->renameColumn('make', 'manufacturer');
            $table->renameColumn('model_year', 'year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
            $table->renameColumn('manufacturer', 'make');
            $table->renameColumn('year', 'model_year');
        });
    }
}
