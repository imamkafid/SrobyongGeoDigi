<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->string('nik', 16)->primary();
            $table->string('nama', 100);
            $table->text('alamat');
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('warga');
    }
};