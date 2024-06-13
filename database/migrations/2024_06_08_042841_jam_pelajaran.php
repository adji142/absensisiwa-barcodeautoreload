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
        Schema::create('jampelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('Deskripsi')->nullable();
            $table->time('JamMulai');
            $table->time('JamSelesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jampelajaran');
    }
};
