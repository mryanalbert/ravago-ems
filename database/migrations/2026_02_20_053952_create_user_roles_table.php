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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('ur_id');
            $table->string('ur_user_id', 50)->index();
            $table->foreignId('ur_role_id')->constrained('roles', 'role_id')->restrictOnDelete();
            $table->boolean('ur_is_active')->default(true);
            $table->longText('ur_update_note');
            $table->string('ur_created_by', 50)->index();
            $table->timestamp('ur_created_ts')->nullable();
            $table->timestamp('ur_updated_ts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
