<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {           
            $table->integer('user_id')->unsigned();
			$table->primary('user_id');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('class_id')->unsigned();
            

            $table->string('number')->nullable();
            $table->date('join_date');
            $table->boolean('active')->default(true);
            $table->boolean('removed')->default(false);
            $table->text('ps')->nullable();

			$table->integer('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('students');
    }
}
