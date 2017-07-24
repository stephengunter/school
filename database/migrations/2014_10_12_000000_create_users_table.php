<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');

            $table->boolean('email_confirmed')->default(false);
			$table->boolean('phone_confirmed')->default(false);

			$table->integer('contact_info')->unsigned()->nullable();

            $table->string('number')->nullable();
            $table->string('fullname')->nullable();
			$table->string('SID')->nullable();
			$table->boolean('gender')->default(true);
			$table->date('dob');

			$table->integer('photo_id')->unsigned()->nullable(); 
			$table->integer('title_id')->unsigned()->nullable(); 
            
            $table->boolean('removed')->default(false);
			$table->integer('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('users');
    }
}
