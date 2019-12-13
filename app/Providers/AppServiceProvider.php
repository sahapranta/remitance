<?php

namespace App\Providers;

use App\Settings;
use Illuminate\Support\ServiceProvider;

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
        // config([
        //     'global' => Settings::all([
        //         'name', 'data'
        //         ])
        //         ->keyBy('name')
        //         ->transform(function ($setting) {return $setting->data; })
        //         ->toArray()
        // ]);
    }
}
