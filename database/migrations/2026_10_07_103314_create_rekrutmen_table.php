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
        Schema::create('rekrutmen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_kerjasama_id')->nullable()->constrained('program_kerjasama')->nullOnDelete();
            $table->foreignId('perusahaan_id')->constrained('perusahaan')->cascadeOnDelete();
            $table->string('judul_lowongan');
            $table->text('persyaratan');
            $table->text('deskripsi_pekerjaan');
            $table->string('lokasi_kerja');
            $table->string('jenis_kerja');
            $table->unsignedInteger('kuota')->nullable();
            $table->date('batas_pendaftaran');
            $table->string('status')->default('open');
            $table->string('link_gform')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekrutmen');
    }
};
