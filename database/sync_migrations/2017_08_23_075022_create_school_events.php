<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolEvents extends Migration
{
    
    public function up()
    {
        Schema::connection('sqlsrv_tp_sync')->create('school_event_calendar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->string('description');
            $table->text('members');
            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->boolean('is_delete')->default(false);
            $table->boolean('sync')->default(false);
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
        Schema::connection('sqlsrv_tp_sync')->dropIfExists('school_event_calendar');
    }
}
