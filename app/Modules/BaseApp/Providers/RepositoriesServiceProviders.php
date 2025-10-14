<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Contact\Repository\ContactInterface;
use App\Modules\Contact\Repository\ContactRepository;

class RepositoriesServiceProviders extends ServiceProvider
{
    public function register()
    {
        $this->app->scoped(
            ContactInterface::class,
            ContactRepository::class
        );
    }
}
