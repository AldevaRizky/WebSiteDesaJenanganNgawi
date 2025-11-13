<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->text('deskripsi');
            $table->text('alamat');
            $table->string('telepon', 20);
            $table->string('email', 255);
            $table->text('lokasi');
            $table->string('link_ig', 255)->nullable();
            $table->string('link_fb', 255)->nullable();
            $table->string('link_wa', 255)->nullable();
            $table->string('link_youtube', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('footer');
    }
};
