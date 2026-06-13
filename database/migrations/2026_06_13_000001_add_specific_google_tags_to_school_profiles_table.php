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
            $table->string('google_site_verification')->nullable()->after('school_description');
            $table->text('google_analytics')->nullable()->after('google_site_verification');
            $table->text('google_tag_manager')->nullable()->after('google_analytics');
            
            if (Schema::hasColumn('school_profiles', 'custom_head_tags')) {
                $table->dropColumn('custom_head_tags');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn('google_site_verification');
            $table->dropColumn('google_analytics');
            $table->dropColumn('google_tag_manager');
            $table->text('custom_head_tags')->nullable();
        });
    }
};
