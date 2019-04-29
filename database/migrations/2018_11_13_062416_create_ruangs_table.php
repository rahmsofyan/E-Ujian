<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruang', function (Blueprint $table) {
            #$table->increments('id');
	   $table->string('idRuang',10);
	   $table->primary('idRuang');
      	   $table->string('namaRuang',50);
   	   $table->decimal('lattitude',10,8);
	   $table->decimal('longitude',11,8);
	   $table->char('floor',2);
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
        Schema::dropIfExists('ruang');
    }
}
