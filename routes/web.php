<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/profil', [PageController::class, 'profil']);
Route::get('/program', [PageController::class, 'program']);
Route::get('/galeri', [PageController::class, 'galeri']);
Route::get('/agenda', [PageController::class, 'agenda']);
Route::get('/fasilitas', [PageController::class, 'fasilitas']);
Route::get('/ekstrakurikuler', [PageController::class, 'ekstrakurikuler']);
Route::get('/kontak', [PageController::class, 'kontak']);

$ppdbSlug = 'pendaftaran';
try {
    if (\Illuminate\Support\Facades\Schema::hasTable('school_profiles')) {
        $profile = \App\Models\SchoolProfile::first();
        if ($profile && !empty($profile->ppdb_slug)) {
            $ppdbSlug = $profile->ppdb_slug;
        }
    }
} catch (\Exception $e) {
    // Ignore if DB not ready
}

Route::get("/{$ppdbSlug}", [PpdbController::class, 'create'])->name('ppdb.create');
Route::post("/{$ppdbSlug}", [PpdbController::class, 'store'])->name('ppdb.store');
Route::post("/{$ppdbSlug}/cek-status", [PpdbController::class, 'checkStatus'])->name('ppdb.check-status');
Route::get("/{$ppdbSlug}/cek-status", function () use ($ppdbSlug) { return redirect("/{$ppdbSlug}"); });
Route::get('/berita', [NewsController::class, 'index']);
Route::get('/berita/{slug}', [NewsController::class, 'show']);
Route::get('/halaman/{slug}', [PageController::class, 'showCustomPage'])->name('custom.page');
Route::post('/contact/send', [\App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

Route::get('/locale/{locale}', [\App\Http\Controllers\LocaleController::class, 'setLocale'])->name('locale.switch');

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);

Route::get('/robots.txt', function () {
    $content = "User-agent: *\n";
    $content .= "Disallow: /admin\n";
    $content .= "Disallow: /login\n";
    $content .= "Disallow: /register\n";
    $content .= "Disallow: /password/reset\n";
    $content .= "Disallow: /forgot-password\n";
    $content .= "Disallow: /reset-password\n";
    $content .= "Disallow: /email/verify\n";
    $content .= "Disallow: /api/\n\n";
    $content .= "Sitemap: " . url('sitemap.xml') . "\n";
    
    return response($content)->header('Content-Type', 'text/plain');
});

Auth::routes();

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Upload TinyMCE
    Route::post('/upload/tinymce', [\App\Http\Controllers\Admin\UploadController::class, 'tinymceUpload'])->name('upload.tinymce');
    
    // --- AKSES BERSAMA (ADMIN & PENULIS) ---
    
    // News (Berita)
    Route::post('news/bulk-destroy', [\App\Http\Controllers\Admin\NewsController::class, 'bulkDestroy'])->name('news.bulkDestroy');
    Route::post('news/import', [\App\Http\Controllers\Admin\NewsController::class, 'import'])->name('news.import');
    Route::get('news/template', [\App\Http\Controllers\Admin\NewsController::class, 'downloadTemplate'])->name('news.template');
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);

    // Agenda
    Route::post('agendas/bulk-destroy', [\App\Http\Controllers\Admin\AgendaController::class, 'bulkDestroy'])->name('agendas.bulkDestroy');
    Route::post('agendas/import', [\App\Http\Controllers\Admin\AgendaController::class, 'import'])->name('agendas.import');
    Route::get('agendas/template', [\App\Http\Controllers\Admin\AgendaController::class, 'downloadTemplate'])->name('agendas.template');
    Route::resource('agendas', \App\Http\Controllers\Admin\AgendaController::class);

    // Galeri (Galleries)
    Route::post('galleries/bulk-destroy', [\App\Http\Controllers\Admin\GalleryController::class, 'bulkDestroy'])->name('galleries.bulkDestroy');
    Route::post('galleries/import', [\App\Http\Controllers\Admin\GalleryController::class, 'import'])->name('galleries.import');
    Route::get('galleries/template', [\App\Http\Controllers\Admin\GalleryController::class, 'downloadTemplate'])->name('galleries.template');
    Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class);

    // --- AKSES KHUSUS ADMIN ---
    Route::group(['middleware' => ['role:admin']], function () {

        // Programs
        Route::post('programs/bulk-destroy', [\App\Http\Controllers\Admin\ProgramController::class, 'bulkDestroy'])->name('programs.bulkDestroy');
        Route::post('programs/import', [\App\Http\Controllers\Admin\ProgramController::class, 'import'])->name('programs.import');
        Route::get('programs/template', [\App\Http\Controllers\Admin\ProgramController::class, 'downloadTemplate'])->name('programs.template');
        Route::resource('programs', \App\Http\Controllers\Admin\ProgramController::class);

        // Fasilitas (Facilities)
        Route::post('facilities/bulk-destroy', [\App\Http\Controllers\Admin\FacilityController::class, 'bulkDestroy'])->name('facilities.bulkDestroy');
        Route::post('facilities/import', [\App\Http\Controllers\Admin\FacilityController::class, 'import'])->name('facilities.import');
        Route::get('facilities/template', [\App\Http\Controllers\Admin\FacilityController::class, 'downloadTemplate'])->name('facilities.template');
        Route::resource('facilities', \App\Http\Controllers\Admin\FacilityController::class);

        // Ekstrakurikuler
        Route::resource('extracurriculars', \App\Http\Controllers\Admin\ExtracurricularController::class);
        Route::post('extracurriculars/bulk-destroy', [\App\Http\Controllers\Admin\ExtracurricularController::class, 'bulkDestroy'])->name('extracurriculars.bulkDestroy');

        // Profil Sekolah (Visi, Misi, Stats)
        Route::get('profiles/edit', [\App\Http\Controllers\Admin\SchoolProfileController::class, 'edit'])->name('profiles.edit');
        Route::put('profiles/update', [\App\Http\Controllers\Admin\SchoolProfileController::class, 'update'])->name('profiles.update');

        // Pengaturan Navigasi
        Route::get('navigations/edit', [\App\Http\Controllers\Admin\NavigationController::class, 'edit'])->name('navigations.edit');
        Route::put('navigations/update', [\App\Http\Controllers\Admin\NavigationController::class, 'update'])->name('navigations.update');

        // Video Profil
        Route::patch('videos/{video}/activate', [\App\Http\Controllers\Admin\VideoController::class, 'activate'])->name('videos.activate');
        Route::resource('videos', \App\Http\Controllers\Admin\VideoController::class)->except(['show']);

        // Halaman Kustom (Pages)
        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class)->except(['show']);

        // Testimoni (Testimonials)
        Route::post('testimonials/bulk-destroy', [\App\Http\Controllers\Admin\TestimonialController::class, 'bulkDestroy'])->name('testimonials.bulkDestroy');
        Route::post('testimonials/import', [\App\Http\Controllers\Admin\TestimonialController::class, 'import'])->name('testimonials.import');
        Route::get('testimonials/template', [\App\Http\Controllers\Admin\TestimonialController::class, 'downloadTemplate'])->name('testimonials.template');
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);

        // Pesan Kontak
        Route::post('messages/bulk-destroy', [\App\Http\Controllers\Admin\ContactMessageController::class, 'bulkDestroy'])->name('messages.bulkDestroy');
        Route::resource('messages', \App\Http\Controllers\Admin\ContactMessageController::class)->only(['index', 'show', 'destroy']);

        // Users (Administrator)
        Route::post('users/import', [\App\Http\Controllers\Admin\UserController::class, 'import'])->name('users.import');
        Route::get('users/template', [\App\Http\Controllers\Admin\UserController::class, 'downloadTemplate'])->name('users.template');
        Route::patch('users/{user}/approve', [\App\Http\Controllers\Admin\UserController::class, 'approve'])->name('users.approve');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

        // Pengaturan Umum
        Route::get('settings/general', [\App\Http\Controllers\Admin\GeneralSettingController::class, 'edit'])->name('settings.general.edit');
        Route::put('settings/general', [\App\Http\Controllers\Admin\GeneralSettingController::class, 'update'])->name('settings.general.update');

        // Backup & Restore
        Route::get('backups', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backups.index');
        Route::post('backups/create', [\App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backups.create');
        Route::get('backups/download/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backups.download');
        Route::delete('backups/destroy/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'destroy'])->name('backups.destroy');
        Route::post('backups/restore', [\App\Http\Controllers\Admin\BackupController::class, 'restore'])->name('backups.restore');

        // Pengaturan PPDB
        Route::get('settings/ppdb', [\App\Http\Controllers\Admin\PpdbSettingController::class, 'edit'])->name('settings.ppdb.edit');
        Route::put('settings/ppdb', [\App\Http\Controllers\Admin\PpdbSettingController::class, 'update'])->name('settings.ppdb.update');

        // Data Pendaftar PPDB
        Route::post('ppdb/bulk-destroy', [\App\Http\Controllers\Admin\PpdbController::class, 'bulkDestroy'])->name('ppdb.bulkDestroy');
        Route::resource('ppdb', \App\Http\Controllers\Admin\PpdbController::class)->only(['index', 'show', 'destroy']);
        Route::put('ppdb/{id}/status', [\App\Http\Controllers\Admin\PpdbController::class, 'updateStatus'])->name('ppdb.status.update');

        // Form Builder
        Route::post('form-builder/sections', [\App\Http\Controllers\Admin\FormBuilderController::class, 'storeSection'])->name('form-builder.sections.store');
        Route::put('form-builder/sections/{section}', [\App\Http\Controllers\Admin\FormBuilderController::class, 'updateSection'])->name('form-builder.sections.update');
        Route::delete('form-builder/sections/{section}', [\App\Http\Controllers\Admin\FormBuilderController::class, 'destroySection'])->name('form-builder.sections.destroy');
        Route::post('form-builder/sections/{section}/duplicate', [\App\Http\Controllers\Admin\FormBuilderController::class, 'duplicateSection'])->name('form-builder.sections.duplicate');

        Route::post('form-builder/fields', [\App\Http\Controllers\Admin\FormBuilderController::class, 'storeField'])->name('form-builder.fields.store');
        Route::put('form-builder/fields/{field}', [\App\Http\Controllers\Admin\FormBuilderController::class, 'updateField'])->name('form-builder.fields.update');
        Route::delete('form-builder/fields/{field}', [\App\Http\Controllers\Admin\FormBuilderController::class, 'destroyField'])->name('form-builder.fields.destroy');

        Route::post('form-builder/requirements', [\App\Http\Controllers\Admin\FormBuilderController::class, 'storeRequirement'])->name('form-builder.requirements.store');
        Route::put('form-builder/requirements/{requirement}', [\App\Http\Controllers\Admin\FormBuilderController::class, 'updateRequirement'])->name('form-builder.requirements.update');
        Route::delete('form-builder/requirements/{requirement}', [\App\Http\Controllers\Admin\FormBuilderController::class, 'destroyRequirement'])->name('form-builder.requirements.destroy');

        Route::post('form-builder/import', [\App\Http\Controllers\Admin\FormBuilderController::class, 'import'])->name('form-builder.import');
        Route::get('form-builder/template', [\App\Http\Controllers\Admin\FormBuilderController::class, 'template'])->name('form-builder.template');
        
    });
});
