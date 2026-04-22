<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->json('name');         // {"ar":"...", "en":"..."}  — Spatie Translatable
            $table->json('description'); // {"ar":"...", "en":"..."}
            $table->string('image')->nullable();
            $table->enum('category', ['beach', 'culture', 'adventure', 'heritage']);
            $table->boolean('is_featured')->default(false);
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
