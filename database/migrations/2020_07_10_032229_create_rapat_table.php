<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapat', function (Blueprint $table) {
            $table->bigIncrements('id_rapat');
            $table->string('id_jenis',5);
            $table->string('id_tempat',5);
            $table->string("hari",10);
            $table->date("tgl_rapat");
            $table->string("jam_mulai",5);
            $table->string("jam_akhir",5);
            $table->string("judul_rapat");
            $table->string("pimpinan_rapat",100);
            $table->string("sifat_rapat",50);
            $table->string("status_rapat",1);
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
        Schema::dropIfExists('rapat');
    }
}
