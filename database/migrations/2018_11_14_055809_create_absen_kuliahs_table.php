<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsenKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absenKuliah', function (Blueprint $table) {
            $table->increments('idAbsen');
	    $table->string('fk_idAgenda',15)->index();
	    $table->date('tglPertemuan');
	    $table->time('waktuMulai');
	    $table->time('waktuSelesai');	
	    $table->integer('pertemuanKe');
	    $table->text('BeritaAcara');
        $table->timestamps();
        });
    

    Schema::table('absenKuliah',function($table){
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
        Schema::dropIfExists('absenKuliah');
    }
}
