<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('bar', function ($user, $foo) {
            return false;
        });

        // Gotcha: boolean return will be used as result for the check
        // If you still want the gate's ability to be checked, return null
        // instead of false.
        Gate::before(function ($user, $ability) {
            if ($user->is_admin) {
                return true;
            }

            if ($user->hasPermission($ability)) {
                return true;
            }
        });

        // Gotcha: if the gate ability check was false, this after check will
        // not be called.
        //Gate::after(function ($user, $ability, $result, $arguments) {
            //if ($user->is_admin) {
                //return true;
            //}

            //if ($user->hasPermission($ability)) {
                //return true;
            //}
        //});
    }
}
