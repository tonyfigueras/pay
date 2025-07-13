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
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quest_id')->constrained()->onDelete('cascade');
            $table->integer('order');
            $table->text('instructions')->nullable();
            $table->enum('activity', ['bring_to', 'talk_to', 'mini_game', 'test']);
            $table->integer('target_npc')->nullable();
            $table->integer('test_id')->nullable();
            $table->integer('item')->nullable();
            $table->foreignId('minigame')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steps');
    }
};
