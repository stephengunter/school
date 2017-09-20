<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeAttachmentTable extends Migration
{
    public function up()
    {
        

        Schema::create('NoticeAttachment', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('Notice_Id')->unsigned();
            $table->foreign('Notice_Id')
            ->references('id')->on('Notices')
            ->onDelete('cascade');
            
            $table->string('Title');
            $table->string('Name');
            $table->string('Type');
            $table->text('FileData');

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
       
    }
}
