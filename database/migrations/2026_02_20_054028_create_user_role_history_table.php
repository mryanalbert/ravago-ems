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
        Schema::create('user_role_history', function (Blueprint $table) {
            $table->bigIncrements('urh_id');
            $table->foreignId('urh_ur_id')->constrained('user_roles', 'ur_id')->restrictOnDelete();
            $table->string('urh_action');
            $table->longText('urh_old_data');
            $table->string('urh_by', 50)->index();
            $table->timestamp('urh_ts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role_history');
    }
};
