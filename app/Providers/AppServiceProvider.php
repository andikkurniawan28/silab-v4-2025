<?php

namespace App\Providers;

use App\Models\Station;
use Illuminate\Support\Facades\View;
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
        $viewStation = Station::select(['id', 'name'])->orderBy('id')->get();
        View::share('viewStation', $viewStation);
    }
}
