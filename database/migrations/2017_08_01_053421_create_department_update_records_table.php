<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentUpdateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_update_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('department_id');
            $table->string('name');
            $table->string('parent')->nullable();
            $table->boolean('delete')->default(false);
            $table->date('date');

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
        Schema::dropIfExists('department_update_records');
    }
}
