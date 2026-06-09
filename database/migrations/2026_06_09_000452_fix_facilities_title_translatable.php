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
        $records = DB::table('facilities')->get();
        
        foreach ($records as $record) {
            $value = $record->title;
            if (!empty($value)) {
                $decoded = json_decode($value, true);
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                    DB::table('facilities')->where('id', $record->id)->update([
                        'title' => json_encode(['id' => $value])
                    ]);
                }
            }
        }

        Schema::table('facilities', function (Blueprint $table) {
            $table->json('title')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
        });
    }
};
