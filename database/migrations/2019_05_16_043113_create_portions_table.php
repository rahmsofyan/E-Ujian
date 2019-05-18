<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portion', function (Blueprint $table) {
            $table->increments('idPorsi');
            $table->string('fk_idAgenda');
            $table->float('porsi1');
            $table->float('porsi2');
            $table->float('porsi3');
            $table->float('porsi4');
            $table->float('total');
            $table->timestamps();
        });

         Schema::table('portion',function($table){
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
        Schema::dropIfExists('portions');
    }
}
