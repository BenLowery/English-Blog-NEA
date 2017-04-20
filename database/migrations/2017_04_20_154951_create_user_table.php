<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 255);
            $table->string('author_name', 255);
            $table->tinyInteger('year');
            $table->enum('role', array('admin', 'user'))->default('user');
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
        Schema::drop('users');
    }
}
