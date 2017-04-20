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
          // defines the primary key
			$table->increments('id');
			// define as a string (VARCHAR)
			$table->string('url', 128)->unique();  // Will throw an error in the database if entry isn’t unique
			$table->string('title', 128)->unique();
			$table->string('description', 255);
			// Nullable allows no value to be entered into this field, everything else is not null by default
			$table->text('tags')->nullable(); 
			 $table->string('author', 255);
			// Enum only allows two values which are defined by us into an array, also define a default value
			 $table->enum('accepted', array('yes', 'no'))->default('no');
			// Timestamps gives each item an added two fields defining when it was made and last updated
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

