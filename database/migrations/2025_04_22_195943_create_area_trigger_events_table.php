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
        Schema::create('area_trigger_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('world_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('shape');
            $table->float('x');
            $table->float('y');
            $table->float('z');
            $table->string('size');  
            $table->string('actions_type');
            $table->boolean('auto_trigger');
            $table->boolean('disabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_trigger_events');
    }
};
