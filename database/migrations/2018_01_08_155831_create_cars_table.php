<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('title');
            $table->string('make');
            $table->string('model');
            $table->mediumText('description')->nullable();
            $table->unsignedSmallInteger('status')->default(1);
            $table->uuid('user_id');
            $table->char('model_year', 4);
            $table->boolean('primary')->default(false);
            $table->string('license', 11)->nullable();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
