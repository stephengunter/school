<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GradeDepartment extends Migration
{
    public function up()
    {
       Schema::create('grade_department', function(Blueprint $table)
        {
             $table->integer('grade_id');
             $table->integer('department_id');
             $table->primary(['grade_id','department_id']);

              $table->foreign('grade_id')->references('id')
                    ->on('grades')->onDelete('cascade');

                $table->foreign('department_id')->references('id')
                ->on('departments')->onDelete('cascade');

        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grade_department');
    }
}
