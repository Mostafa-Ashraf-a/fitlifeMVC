<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

//use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * UserDataRequest any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Passport::tokensCan([
            'customer' => 'Can view videos',
        ]);

        Passport::setDefaultScope([
            'customer',
        ]);
//        // This is going to add routes specifically for issuing and revoking tokens.
//        Passport::routes(null, ['prefix'=> 'v1/customer']);
//
//        // Other potential config options for my tokens
//        Passport::tokensExpireIn(now()->addHours(1));
    }
}
