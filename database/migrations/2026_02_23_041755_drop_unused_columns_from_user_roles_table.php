<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
            // Step 1: Remove AUTO_INCREMENT from ur_id so it can be dropped
            DB::statement('ALTER TABLE user_roles MODIFY ur_id BIGINT NULL');

            // Step 2: Drop the unwanted columns
            $table->dropColumn([
                'ur_id',
                'ur_is_active',
                'ur_update_note',
                'ur_created_by',
                'ur_created_ts',
                'ur_updated_ts',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
            // Recreate ur_id as auto-increment PK (if needed)
            $table->bigIncrements('ur_id');

            // Recreate the other columns
            $table->boolean('ur_is_active')->default(true);
            $table->text('ur_update_note')->nullable();
            $table->string('ur_created_by')->nullable();
            $table->timestamp('ur_created_ts')->nullable();
            $table->timestamp('ur_updated_ts')->nullable();
        });
    }
};
