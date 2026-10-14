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
        Schema::create('program_kerjasama', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mou_id')->constrained('mou')->cascadeOnDelete();
            $table->string('nama_program');
            $table->string('jenis')->default('lainnya');
            $table->text('deskripsi');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->unsignedInteger('kuota')->nullable();
            $table->string('status')->default('planned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_kerjasama');
    }
};
