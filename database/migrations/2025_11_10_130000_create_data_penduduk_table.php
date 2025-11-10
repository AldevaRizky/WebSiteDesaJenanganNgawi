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
        Schema::create('data_penduduk', function (Blueprint $table) {
            $table->id();
            // Total population
            $table->unsignedInteger('total_penduduk')->default(0);
            // Number of households / kepala keluarga
            $table->unsignedInteger('kepala_keluarga')->default(0);
            // Male population
            $table->unsignedInteger('laki_laki')->default(0);
            // Female population
            $table->unsignedInteger('perempuan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_penduduk');
    }
};
