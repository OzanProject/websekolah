<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useTailwind();

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('school_profiles')) {
                $profile = \App\Models\SchoolProfile::first();
                if ($profile) {
                    if ($profile->school_name) {
                        config(['app.name' => $profile->school_name]);
                        config(['adminlte.title' => $profile->school_name]);
                        config(['adminlte.title_postfix' => ' | ' . $profile->school_name]);
                        config(['adminlte.logo' => '<b>' . $profile->school_name . '</b>']);
                    }
                    if ($profile->school_logo) {
                        config(['adminlte.logo_img' => 'storage/' . $profile->school_logo]);
                    }

                    // Share global profile data to all frontend views
                    \Illuminate\Support\Facades\View::composer('*', function ($view) use ($profile) {
                        $view->with([
                            'schoolProfile' => $profile,
                            'globalSchoolName' => $profile->school_name ?? 'SMP Negeri 4 Kadupandak',
                            'globalSchoolTagline' => $profile->school_tagline ?? 'Berkarakter, Berprestasi, Berakhlak Mulia',
                        ]);
                    });
                }
            }
        } catch (\Exception $e) {
            // Abaikan jika database/tabel belum ada (misal saat setup awal)
        }
    }
}
