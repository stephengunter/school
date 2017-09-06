<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupSyncTable extends Migration
{
    public function up()
    {
        

        Schema::connection('sqlsrv_tp_sync')->create('group_sync', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tp_id')->unsigned()->default(0);
            $table->string('parent')->nullable(); 
            $table->string('code')->nullable(); 
            $table->string('name')->nullable();
            $table->string('admin')->nullable();
            $table->text('members')->nullable();

            $table->boolean('is_delete')->default(false);
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
        Schema::connection('sqlsrv_tp_sync')->dropIfExists('group_sync');
    }
}
