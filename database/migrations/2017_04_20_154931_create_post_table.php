<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create post table
         Schema::create('post', function (Blueprint $table) {
            $table->increments('id');
            // define as a string (VARCHAR 255)
            $table->string('url', 128)->unique();
            $table->string('title', 128)->unique();
            $table->string('description', 255);
            $table->text('tags')->nullable();
            $table->string('author', 255);
            $table->enum('accepted', array('yes', 'no'))->default('no');
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
        // Delete table incase
        Schema::drop('post');
    }
}

