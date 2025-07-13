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
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('world_id')->constrained()->cascadeOnDelete();
            $table->json('completed_actions')->nullable(); 
            $table->json('unlocked_worlds')->nullable();
            $table->timestamp('last_played_at')->nullable();
            $table->timestamps();            
            $table->unique(['user_id', 'world_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
