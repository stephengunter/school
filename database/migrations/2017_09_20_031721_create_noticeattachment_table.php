<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeAttachmentTable extends Migration
{
    public function up()
    {
        

        Schema::create('NoticeAttachment', function (Blueprint $table) {
            $table->increments('Id');

            $table->integer('Notice_Id')->unsigned();
            $table->foreign('Notice_Id')
            ->references('Id')->on('Notices')
            ->onDelete('cascade');
            
            $table->string('Title');
            $table->string('Name');
            $table->string('Type');
            $table->text('FileData');

            $table->string('CreatedBy')->nullable();
            $table->string('UpdatedBy')->nullable();

            $table->datetime('CreatedAt')->nullable();
            $table->datetime('UpdatedAt')->nullable();
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
