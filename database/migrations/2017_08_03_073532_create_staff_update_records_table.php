<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffUpdateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv_tp_sync')->create('staff_update_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('number');
            $table->string('department');
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('job_title')->nullable();
            $table->string('extend')->nullable();
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
        Schema::connection('sqlsrv_tp_sync')->dropIfExists('staff_update_records');
    }
}
