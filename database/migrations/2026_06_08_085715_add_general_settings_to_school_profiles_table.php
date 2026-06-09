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
            $table->string('school_name')->nullable();
            $table->string('school_tagline')->nullable();
            $table->string('school_logo')->nullable();
            $table->string('school_npsn')->nullable();
            $table->string('school_nss')->nullable();
            $table->string('school_accreditation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'school_name',
                'school_tagline',
                'school_logo',
                'school_npsn',
                'school_nss',
                'school_accreditation',
            ]);
        });
    }
};
