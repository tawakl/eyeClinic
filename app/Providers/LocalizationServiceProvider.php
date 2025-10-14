<?php

declare(strict_types = 1);

namespace App\Providers;

use Mcamara\LaravelLocalization\LaravelLocalization;
use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider;

class LocalizationServiceProvider extends LaravelLocalizationServiceProvider
{
    protected function registerBindings()
    {
//        $fn = fn () => new LaravelLocalization();

        // the conditional check below is important
        // when you do caching routes via `php artisan route:trans:cache` if binding
        // via `bind` used you will get incorrect serialized translated routes in cache
        // files and that's why you'll get broken translatable route URLs in UI

        // again, if you don't use translatable routes, you may get rid of this check
        // and leave only 'bind()' here

        // the 3rd parameter is important to be passed to 'bind'
        // otherwise the package's instance will be instantiated every time
        // you reference it and it won't get proper data for 'serialized translatable routes'
        // class variable, this will make impossible to use translatable routes properly
        // but oveall the package will still work stable except generating the same URLs
        // for translatable routes independently of locale

        if ($this->runningInOctane()) {
            $this->app->bind(LaravelLocalization::class, LaravelLocalization::class ,true);
        } else {
            $this->app->singleton(LaravelLocalization::class , LaravelLocalization::class);
        }

        $this->app->alias(LaravelLocalization::class, 'laravellocalization');
    }

    private function runningInOctane(): bool
    {
        return !$this->app->runningInConsole() && env('LARAVEL_OCTANE');
    }
}
