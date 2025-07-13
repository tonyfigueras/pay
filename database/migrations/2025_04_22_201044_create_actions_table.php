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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('actionable_id');
            $table->string('actionable_type');
            $table->string('action_type');
            $table->foreignId('parent_id')->nullable()->constrained('actions');
            $table->integer('order')->default(0);
            $table->json('properties')->nullable();
            $table->json('detail')->nullable();
            $table->unsignedBigInteger('_lft')->default(0);
            $table->unsignedBigInteger('_rgt')->default(0);
            $table->timestamps();
            $table->index(['actionable_type', 'actionable_id']);
            $table->index(['_lft', '_rgt', 'parent_id']);
        });
    }

      /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};
