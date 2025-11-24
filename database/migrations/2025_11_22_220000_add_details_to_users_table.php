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
        Schema::table('users', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->after('email');
            $table->string('phone')->nullable()->after('jabatan');
            $table->text('alamat')->nullable()->after('phone');
            $table->string('profile')->nullable()->after('alamat')->comment('profile photo path stored on public disk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'phone', 'alamat', 'profile']);
        });
    }
};
