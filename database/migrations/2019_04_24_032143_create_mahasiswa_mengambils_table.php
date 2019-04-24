<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMahasiswaMengambilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_mengambils', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nrp',15);
            $table->foreign('nrp')
                ->references('nrp')
                ->on('mahasiswas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('mkid',15);
            $table->foreign('mkid')
                    ->references('mkid')
                    ->on('matakuliahs')
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
        Schema::dropIfExists('mahasiswa_mengambils');
    }
}
