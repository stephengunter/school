<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id')->unsigned();
			$table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->string('title');
            $table->integer('user_id')->unsigned()->nullable();

            $table->boolean('active')->default(true);
            $table->boolean('leader')->default(false);
            $table->boolean('vice_leader')->default(false);
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
        Schema::dropIfExists('job_positions');
    }
}
