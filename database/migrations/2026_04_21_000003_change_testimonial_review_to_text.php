<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change column type first so MySQL accepts non-JSON values
        Schema::table('testimonials', function (Blueprint $table) {
            $table->text('review')->change();
        });

        // Now extract Arabic text from any rows that still hold JSON
        DB::table('testimonials')->get()->each(function ($row) {
            $raw = $row->review;
            if (is_null($raw)) return;

            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $plain = $decoded['ar'] ?? $decoded['en'] ?? $raw;
                DB::table('testimonials')
                    ->where('id', $row->id)
                    ->update(['review' => $plain]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->json('review')->change();
        });
    }
};
