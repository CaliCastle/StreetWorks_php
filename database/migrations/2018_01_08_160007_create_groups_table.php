<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('title');
            $table->unsignedSmallInteger('status')->default(1);
            $table->mediumText('description')->nullable();
            $table->uuid('user_id');
            $table->uuid('image_id');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images');
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('group_id');
            $table->unsignedSmallInteger('status');
            $table->timestamps();

            $table->primary(['user_id', 'group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_user');
        Schema::dropIfExists('groups');
    }
}
