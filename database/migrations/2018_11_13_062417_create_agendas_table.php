<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            #$table->increments('idAgenda');
	    $table->string('idAgenda',15);
	    $table->primary('idAgenda');
	    $table->string('namaAgenda');
	    $table->date('tanggal')->nullable();
	    $table->string('hari',10);	
	    $table->string('fk_idRuang',10)->index();
	    $table->time('WaktuMulai');
	    $table->time('WaktuSelesai');
	    $table->string('fk_idPIC',25) ->index();
	    $table->text('notule');
            $table->timestamps();
        });

   	Schema::table('agenda',function($table){
        $table->foreign('fk_idRuang')
         ->references('idRuang')
             ->on('ruang')
             ->onUpdate('cascade')
             ->onDelete('cascade');
        });


        Schema::table('agenda',function($table){
        $table->foreign('fk_idPIC')
         ->references('idPIC')
             ->on('pic')
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
        Schema::dropIfExists('agenda');
    }
}
