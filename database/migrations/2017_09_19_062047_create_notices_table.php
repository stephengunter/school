<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Notices', function (Blueprint $table) {
            $table->increments('id');
            $table->text('Content')->nullable(); 
            $table->boolean('Staff')->default(false);
            $table->boolean('Teacher')->default(false);
            $table->boolean('Student')->default(false);
            $table->text('Units')->nullable(); 
            $table->text('Classes')->nullable(); 
            $table->string('Levels')->nullable(); 

            $table->boolean('Reviewed')->default(false);
            
            
            $table->string('CreatedBy')->nullable();
            $table->string('UpdatedBy')->nullable();
            $table->string('ReviewedBy')->nullable();

            $table->datetime('CreatedAt')->nullable();
            $table->datetime('UpdatedAt')->nullable();

            $table->text('PS')->nullable(); 
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('NoticeAttachment');
        Schema::dropIfExists('Notices');
    }
}
