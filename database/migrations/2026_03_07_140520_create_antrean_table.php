<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('antrean', function (Blueprint $table) {
            $table->id('id_antrean');

            $table->unsignedBigInteger('id_pasien');
            $table->unsignedBigInteger('id_dokter');

            $table->integer('nomor_antrean');
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai']);

            $table->timestamps();

            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->cascadeOnDelete();
            $table->foreign('id_dokter')->references('id_dokter')->on('dokter')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrean');
    }
};
