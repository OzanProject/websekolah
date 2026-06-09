<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $records = DB::table('testimonials')->get();
        
        foreach ($records as $record) {
            $value = $record->quote;
            if (!empty($value)) {
                $decoded = json_decode($value, true);
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                    DB::table('testimonials')->where('id', $record->id)->update([
                        'quote' => json_encode(['id' => $value])
                    ]);
                }
            }
        }

        Schema::table('testimonials', function (Blueprint $table) {
            $table->json('quote')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->text('quote')->nullable()->change();
        });
    }
};
