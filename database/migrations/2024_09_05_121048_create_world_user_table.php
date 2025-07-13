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
        Schema::create('world_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('world_id');
            $table->boolean('locked')->default(true);
            $table->boolean('completed')->default(false);
            $table->boolean('is_active')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->boolean('intro_seen')->default(false);
            $table->boolean('tutorial_completed')->default(false);
            $table->json('triggered_events');
            $table->unique(['user_id', 'world_id']);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('world_user');
    }
};
