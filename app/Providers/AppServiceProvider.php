<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        setlocale(LC_ALL, 'id_ID.utf8');
        Carbon::setLocale('id_ID.utf8');
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_ALL, 'id_ID.utf8');
        Carbon::setLocale('id_ID.utf8');
        date_default_timezone_set('Asia/Jakarta');
        Blade::withDoubleEncoding();
    }
}