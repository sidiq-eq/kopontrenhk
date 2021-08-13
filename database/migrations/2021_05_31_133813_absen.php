<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Absen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('absen');
        Schema::create('absen', function (Blueprint $table) {
            $table->id('id_absen');
            $table->string('id_karyawan');
            $table->time('waktu');
            $table->date('tgl');
            $table->string('ket');
            $table->string('lokasi');
            $table->string('foto');
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
