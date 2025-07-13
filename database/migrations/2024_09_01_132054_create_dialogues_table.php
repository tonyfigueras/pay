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
        Schema::create('dialogues', function (Blueprint $table) {
            $table->id();
            $table->text('dialogue_name');
            $table->foreignId('step_id')->nullable();
            $table->foreignId('previous_dialogue_id')->nullable();
            $table->foreignId('non_playable_character_id');
            $table->boolean('has_test')->default(false);
            $table->boolean('previous_step_completed')->default(false);
            $table->integer('test_on_order')->nullable();
            $table->boolean('can_be_repeated')->default(true);
            $table->integer('alternative_dialogue_id')->nullable();
            /*
             * 'dialogue_name',
        'step_id', // nullable
        'non_playable_character_id',
        'previous_step_completed',
        'can_be_repeated',
             */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dialogues');
    }
};
