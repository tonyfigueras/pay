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
        Schema::create('audios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('world_id');
            $table->string('name');
            $table->text('resources');
            $table->boolean('loop');
            $table->float('x');
            $table->float('y');
            $table->float('z');
            $table->integer('distance');
            $table->integer('maxDistance');
            $table->json('volumeDucking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
