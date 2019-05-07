<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DaftarNilai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftarnilai', function (Blueprint $table) {
            $table->string('idPenilaian');
            $table->string('idUser',20);
            $table->float('nilai');
            $table->foreign('idPenilaian')->references('idPenilaian')->on('penilaians')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('idUser')->references('idUser')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
        //
    }
}
