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
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->text('visi')->nullable();
            $table->json('misi')->nullable();
            $table->integer('stat_student')->default(0);
            $table->integer('stat_teacher')->default(0);
            $table->integer('stat_class')->default(0);
            $table->integer('stat_achievement')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};
