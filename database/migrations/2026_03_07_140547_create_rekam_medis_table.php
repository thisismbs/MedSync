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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id('id_rekam'); // PK sesuai ERD
            $table->unsignedBigInteger('id_pasien'); // FK ke pasien
            $table->unsignedBigInteger('id_dokter'); // FK ke dokter
            $table->date('tanggal');
            $table->text('diagnosa');
            $table->text('tindakan');
            $table->timestamps();

            // Bikin relasi
            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->onDelete('cascade');
            $table->foreign('id_dokter')->references('id_dokter')->on('dokter')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
