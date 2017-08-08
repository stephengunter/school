<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateDepartmentUpdateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv_teamplus')->create('department_update_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('department_id');
            $table->string('name');
            $table->string('parent')->nullable();
            $table->string('type')->nullable();
            $table->boolean('delete')->default(false);
            $table->date('date')->default(Carbon::today());

            $table->boolean('done')->default(false);
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
        Schema::connection('sqlsrv_teamplus')->dropIfExists('department_update_records');
    }
}
