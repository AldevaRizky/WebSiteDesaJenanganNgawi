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
        Schema::create('perangkat_desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            // parent_id to represent hierarchy for bagan (organizational chart)
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->integer('order')->default(0)->comment('Ordering within siblings');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            // optionally add a foreign key to self - commented out for compatibility
            // $table->foreign('parent_id')->references('id')->on('perangkat_desas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perangkat_desas');
    }
};
