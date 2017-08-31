<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeAttachmentTable extends Migration
{
    public function up()
    {
        

        Schema::connection('sqlsrv_tp_sync')->create('school_notice_attachment', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('notice_id')->unsigned();
            $table->foreign('notice_id')
            ->references('id')->on('school_notice_sync')
            ->onDelete('cascade');
            
            $table->string('display_name');
            $table->string('file_type');
            $table->text('file_data');

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
        Schema::connection('sqlsrv_tp_sync')->dropIfExists('school_notice_attachment');
    }
}
