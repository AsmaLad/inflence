<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        \Illuminate\Support\Facades\Blade::directive('routeIs', function ($expression) {
            return "<?php if(request()->routeIs($expression)): ?>";
        });

        \Illuminate\Support\Facades\Route::macro('isAdmin', function () {
            return request()->user()->isAdmin();
        });

    }
}
