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
        Schema::connection('sqlsrv_tp_sync')->create('department_update_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('department_id');
            $table->string('name');
            $table->string('parent')->nullable();
            $table->boolean('is_delete')->default(false);

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
        Schema::connection('sqlsrv_tp_sync')->dropIfExists('department_update_records');
    }
}
