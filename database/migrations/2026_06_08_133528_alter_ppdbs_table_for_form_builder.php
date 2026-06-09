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
        Schema::table('ppdbs', function (Blueprint $table) {
            $table->dropColumn([
                'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'nisn', 
                'asal_sekolah', 'alamat', 'no_hp', 'email', 'nama_ortu', 
                'pekerjaan_ortu', 'no_hp_ortu'
            ]);
            $table->json('form_data')->nullable()->after('nomor');
            $table->json('requirements_data')->nullable()->after('form_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppdbs', function (Blueprint $table) {
            //
        });
    }
};
