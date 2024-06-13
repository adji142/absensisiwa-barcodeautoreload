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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('NIS')->unique();
            $table->string('NamaSiswa');
            $table->string('TahunAjaran');
            $table->string('Email');
            $table->string('Phone');
            $table->string('TempatLahir');
            $table->date('TanggalLahir');
            $table->foreignId('Kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
