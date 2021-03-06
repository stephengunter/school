<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateStudentUpdateRecordsTable extends Migration
{
   
    public function up()
    {
       Schema::connection('sqlsrv_tp_sync')->create('student_update_records', function (Blueprint $table) {
          
            $table->increments('id');
            $table->string('name');
            $table->string('number');
            $table->string('department');
            $table->string('email');
            $table->string('password')->nullable();
            
            $table->integer('status');

            $table->boolean('done')->default(false);
            $table->boolean('success')->default(false);
            $table->string('msg')->nullable();
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
        Schema::connection('sqlsrv_tp_sync')->dropIfExists('student_update_records');
    }
}
