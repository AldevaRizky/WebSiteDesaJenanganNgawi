<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('data_stunting') && Schema::hasColumn('data_stunting', 'anak_id')) {
            // Use CHANGE which works on older MySQL/MariaDB versions
            DB::statement("ALTER TABLE `data_stunting` CHANGE `anak_id` `nama_anak` VARCHAR(255) NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('data_stunting') && Schema::hasColumn('data_stunting', 'nama_anak')) {
            DB::statement("ALTER TABLE `data_stunting` CHANGE `nama_anak` `anak_id` VARCHAR(255) NOT NULL");
        }
    }
};
