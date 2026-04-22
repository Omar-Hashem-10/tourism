<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['image', 'flag']);
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('flag')->nullable();
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->string('image')->nullable();
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('avatar')->nullable();
        });
    }
};
