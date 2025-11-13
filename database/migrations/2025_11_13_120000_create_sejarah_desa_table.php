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
        // Note: table name uses underscore 'sejarah_desa' instead of space
        Schema::create('sejarah_desa', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('subjudul', 255)->nullable();
            $table->string('gambar', 255)->nullable();
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sejarah_desa');
    }
};
