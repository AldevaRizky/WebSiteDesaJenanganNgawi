<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Footer;

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
        Paginator::useBootstrap();
        $footer = null;
        try {
            $table = (new Footer())->getTable();
            if (Schema::hasTable($table)) {
                $footer = Footer::first();
            }
        } catch (\Throwable $e) {
            $footer = null;
        }

        View::share('footer', $footer);
    }
}
