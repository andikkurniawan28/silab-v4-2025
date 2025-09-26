<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
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

        view()->composer('*', function ($view) {
            $jamSekarang = Carbon::now()->format('H:i');
            $jamLogout = ["05:00", "13:00", "21:00"];
            if (Auth::check() && in_array($jamSekarang, $jamLogout)) {
                Auth::logout();
                Session::flush();
            }
        });
    }
}
