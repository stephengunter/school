<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->unsigned()->default(0);
            $table->string('code')->nullable();	
			$table->string('name');	
            $table->string('en_name')->nullable();		
            	
            $table->text('description')->nullable(); 
            $table->integer('order')->default(0);
            $table->string('icon')->nullable(); 

            $table->boolean('active')->default(true);
            $table->boolean('removed')->default(false);	
            $table->integer('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('departments');
    }
}
