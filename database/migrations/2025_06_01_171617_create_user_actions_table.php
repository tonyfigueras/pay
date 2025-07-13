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
       Schema::create('user_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('actionable'); // Crea 'actionable_id' + 'actionable_type'
            $table->foreignId('action_id')->constrained('actions');
            $table->json('state')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            
            // Campos para NestedSet
            $table->unsignedBigInteger('parent_id')->nullable(); // <-- Solo para lógica interna
            $table->unsignedBigInteger('_lft')->default(0);
            $table->unsignedBigInteger('_rgt')->default(0);
            
            $table->timestamps();
            
            // Índices para optimización
            $table->index(['_lft', '_rgt', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_actions');
    }
};

