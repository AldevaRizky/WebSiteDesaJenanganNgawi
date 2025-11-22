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
        // Only attempt to drop columns when they exist to avoid migration errors
        if (Schema::hasTable('perangkat_desas')) {
            $drops = [];
            if (Schema::hasColumn('perangkat_desas', 'parent_id')) {
                $drops[] = 'parent_id';
            }
            if (Schema::hasColumn('perangkat_desas', 'order')) {
                $drops[] = 'order';
            }

            if (!empty($drops)) {
                Schema::table('perangkat_desas', function (Blueprint $table) use ($drops) {
                    $table->dropColumn($drops);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perangkat_desas', function (Blueprint $table) {
            // Recreate the dropped columns in a sensible default form
            if (!Schema::hasColumn('perangkat_desas', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->index();
            }
            if (!Schema::hasColumn('perangkat_desas', 'order')) {
                $table->integer('order')->default(0)->comment('Ordering within siblings');
            }
        });
    }
};
