<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('source_user_id');
            $table->uuid('target_user_id');
            $table->smallInteger('action_type');
            $table->smallInteger('object_type');
            $table->uuid('object_id');
            $table->timestamps();

            $table->foreign('source_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('target_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
