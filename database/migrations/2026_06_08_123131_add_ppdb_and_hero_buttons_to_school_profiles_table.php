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
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->boolean('ppdb_active')->default(false);
            $table->string('ppdb_title')->nullable();
            $table->string('ppdb_year')->nullable();
            $table->text('ppdb_description')->nullable();
            $table->string('hero_btn1_text')->nullable();
            $table->string('hero_btn1_url')->nullable();
            $table->string('hero_btn2_text')->nullable();
            $table->string('hero_btn2_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'ppdb_active',
                'ppdb_title',
                'ppdb_year',
                'ppdb_description',
                'hero_btn1_text',
                'hero_btn1_url',
                'hero_btn2_text',
                'hero_btn2_url',
            ]);
        });
    }
};
