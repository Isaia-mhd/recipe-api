<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define("update-role", fn($user) => $user->role === "admin");
        Gate::define("delete-user", fn($user, $userInfo) => $user->id === $userInfo->id);
        Gate::define("update-recipe", fn($user, $userOwnerId) => $user->id === $userOwnerId);
        Gate::define("delete-recipe", fn($user, $userOwnerId) => $user->id === $userOwnerId);
        Gate::define("delete-favorite", fn($user, $userOwnerId) => $user->id === $userOwnerId);


    }
}
