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
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string('NIK');
            $table->string('NamaGuru');
            $table->string('Email');
            $table->string('Phone');
            $table->string('TempatLahir')->nullable();
            $table->string('TanggalLahir')->nullable();
            $table->foreignId('mapel_id')->constrained('matapelajaran')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};