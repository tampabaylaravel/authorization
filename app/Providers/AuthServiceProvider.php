<?php

namespace App\Providers;

use Illuminate\Auth\Access\AuthorizationException;
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

        // Gotcha: boolean return will be used as result for the check
        // If you still want the gate's ability to be checked, return null
        // instead of false.
        Gate::before(function ($user, $ability, $arguments) {
            if ($user->is_admin) {
                return true;
            }

            if ($this->userHasPermission($user, $ability, $arguments)) {
                return true;
            }
        });
    }

    private function userHasPermission($user, $ability, $arguments = [])
    {
        return isset($arguments[0])
            ? $user->hasPermission($this->permissionGenerator($ability, $arguments[0]))
            : $user->hasPermission($ability);
    }

    private function permissionGenerator($ability, $class)
    {
        if (is_string($class) && !class_exists($class)) {
            throw new AuthorizationException('fancy message here');
        }

        $className = strtolower(class_basename($class));

        return "$ability-$className";
    }
}
