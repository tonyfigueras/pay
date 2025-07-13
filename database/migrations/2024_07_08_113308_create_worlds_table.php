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
          Schema::create('worlds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('galaxy_id')->constrained('galaxies');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->integer('order');
            $table->string('glb');
            $table->float('default_spawn_x');
            $table->float('default_spawn_y');
            $table->float('default_spawn_z');
            $table->json('sections')->nullable(); 
            $table->boolean('intro_seen')->default(false); 
            $table->boolean('tutorial_completed')->default(false); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worlds');
    }
};
