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
        Schema::table('data_stunting', function (Blueprint $table) {
            $table->renameColumn('anak_id', 'nama_anak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_stunting', function (Blueprint $table) {
            $table->renameColumn('nama_anak', 'anak_id');
        });
    }
};
