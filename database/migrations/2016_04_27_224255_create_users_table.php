<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->char('fname',20);
            $table->char('lname',20);
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_admin')->default('0');
            $table->boolean('is_active')->default('1');
            $table->integer('section')->unsigned();
            $table->foreign('section')->references('id')->on('categories')->onDelete('cascade');
            $table->rememberToken();
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
        //
    }
}
