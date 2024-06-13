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
        Schema::create('generatebarcodeabsensi', function (Blueprint $table) {
            $table->id();
            $table->datetime('Tanggal');
            $table->foreignId('jadwal_id')->constrained('jadwalpelajaran')->cascadeOnDelete();
            $table->string('uuid');
            $table->integer('valid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generatebarcodeabsensi');
    }
};
