<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHukumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hukum', function (Blueprint $table) {
            $table->bigIncrements('id_hukum');
            $table->integer('kelompok');
            $table->integer('kategori');
            $table->string('nama_hukum');
            $table->text('tentang');
            $table->string('tgl_hukum');
            $table->string('status_hukum');
            $table->text('file_hukum');
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
        Schema::dropIfExists('hukum');
    }
}
