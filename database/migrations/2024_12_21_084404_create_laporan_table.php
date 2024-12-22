<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('nik_pelapor', 16);
            $table->text('deskripsi');
            $table->string('media_path')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->enum('status', ['Menunggu', 'Ditolak', 'Proses', 'Selesai'])->default('Menunggu');
            $table->timestamps();

            $table->foreign('nik_pelapor')
                  ->references('nik')
                  ->on('warga')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan');
    }
};