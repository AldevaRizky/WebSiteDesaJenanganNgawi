<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kategori_berita', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 191);
            $table->string('slug', 191)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_berita');
    }
};
