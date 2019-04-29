<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->increments('idLog');
	    $table->string('fk_idUser',25)->index();
	    $table->string('fk_idAgenda',15)->index();
	    $table->text('status');
	    $table->decimal('lattitudeHP',10,8);
	    $table->decimal('longitudeHP',11,8);
	    $table->string('namaFileFOTO',50);
            $table->timestamps();
        });


	Schema::table('log',function($table){
        $table->foreign('fk_idUser')
         ->references('idUser')
             ->on('users')
             ->onUpdate('cascade')
             ->onDelete('cascade');
        });


        Schema::table('log',function($table){
        $table->foreign('fk_idAgenda')
         ->references('idAgenda')
             ->on('agenda')
             ->onUpdate('cascade')
             ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log');
    }
}
