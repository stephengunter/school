<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolNoticeSyncTable extends Migration
{
    public function up()
    {
        

        Schema::connection('sqlsrv_tp_sync')->create('school_notice_sync', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('type_id');
            $table->text('text_content')->nullable(); 
            $table->text('members');
			$table->string('created_by')->nullable();
			
			
            $table->text('media_content')->nullable(); 
            
            
            $table->boolean('sync')->default(false);
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
        Schema::connection('sqlsrv_tp_sync')->dropIfExists('school_notice_sync');
    }
}
