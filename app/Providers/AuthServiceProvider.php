<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Item;
use App\Policies\StockPolicy;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Item::class => StockPolicy::class,
    ];

    /**
     * we call the passport: routes
     * to register routes that our application will use * to issue tokens and clients
     * @return void
     */
    public function boot()
    {
         $this->registerPolicies();

    }
}
