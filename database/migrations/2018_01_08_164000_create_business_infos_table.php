<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');
            $table->string('description')->nullable();
            $table->string('address_1');
            $table->string('address_2');
            $table->string('address_3');
            $table->string('city');
            $table->char('state', 2);
            $table->char('country', 3);
            $table->char('phone', 11);
            $table->string('email')->unique();
            $table->timestamps();

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
        Schema::dropIfExists('business_infos');
    }
}
