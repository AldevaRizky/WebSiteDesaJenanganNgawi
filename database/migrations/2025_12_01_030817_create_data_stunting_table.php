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
        Schema::create('data_stunting', function (Blueprint $table) {
            $table->id();
            $table->string('anak_id');
            $table->date('tanggal_pengukuran');
            $table->integer('umur_bulan');
            $table->decimal('tinggi_badan_cm', 5, 2);
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('lingkar_kepala', 5, 2)->nullable();
            $table->decimal('lingkar_lengan', 5, 2)->nullable();
            $table->enum('status_stunting', ['normal', 'stunting', 'severely_stunting', 'tinggi'])->default('normal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_stunting');
    }
};
