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
        Schema::create('section_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('world_id');
            $table->integer('section_id');
            $table->boolean('is_active')->default(false);
            $table->boolean('completed');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_user');
    }
};
