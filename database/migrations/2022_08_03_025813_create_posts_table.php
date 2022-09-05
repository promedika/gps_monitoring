<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('outlet_name');
            $table->string('outlet_user');
            $table->dateTime('imgTaken');
            $table->string('imgLoc');
            $table->integer('user_id');
            $table->string('user_fullname');
            $table->string('outlet_name_id');
            $table->string('outlet_user_id');
            $table->string('post_header_id');
            $table->string('activity');
            $table->string('jabatan_id');
            $table->string('jabatan_name');
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
        Schema::dropIfExists('posts');
    }
}
