<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatakuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matakuliahs', function (Blueprint $table) {
            $table->string('mkid',15);
            $table->primary('mkid');
            $table->string('nama',20);
            $table->string('nip_dosen',15);
            $table->foreign('nip_dosen')
                ->references('nip')
                ->on('dosens')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                $table->string('status');
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
        Schema::dropIfExists('matakuliahs');
    }
}
