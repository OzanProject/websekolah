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
        $tables = [
            'news' => ['title', 'content'],
            'programs' => ['title', 'description'],
            'facilities' => ['name', 'description'],
            'testimonials' => ['message'],
            'galleries' => ['title'],
            'school_profiles' => ['visi', 'sambutan_content', 'ppdb_title', 'ppdb_description']
        ];

        foreach ($tables as $table => $columns) {
            if (Schema::hasTable($table)) {
                // Konversi data lama ke JSON format translatable
                $records = DB::table($table)->get();
                
                foreach ($columns as $column) {
                    if (Schema::hasColumn($table, $column)) {
                        // 1. Ubah data lama ke format JSON string yang valid terlebih dahulu
                        foreach ($records as $record) {
                            $value = $record->$column;
                            if (!empty($value)) {
                                // Cek apakah sudah JSON yang valid
                                $decoded = json_decode($value, true);
                                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                                    // Belum JSON, bungkus dengan key 'id'
                                    DB::table($table)->where('id', $record->id)->update([
                                        $column => json_encode(['id' => $value])
                                    ]);
                                }
                            }
                        }

                        // 2. Setelah data di dalam kolom adalah valid JSON string, baru ubah tipe kolom
                        Schema::table($table, function (Blueprint $table) use ($column) {
                            $table->json($column)->nullable()->change();
                        });
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Untuk rollback, kita kembalikan ke format text
        $tables = [
            'news' => ['title', 'content'],
            'programs' => ['title', 'description'],
            'facilities' => ['name', 'description'],
            'testimonials' => ['message'],
            'galleries' => ['title'],
            'school_profiles' => ['visi', 'sambutan_content', 'ppdb_title', 'ppdb_description']
        ];

        foreach ($tables as $table => $columns) {
            if (Schema::hasTable($table)) {
                foreach ($columns as $column) {
                    if (Schema::hasColumn($table, $column)) {
                        Schema::table($table, function (Blueprint $table) use ($column) {
                            $table->text($column)->nullable()->change();
                        });
                    }
                }
            }
        }
    }
};
