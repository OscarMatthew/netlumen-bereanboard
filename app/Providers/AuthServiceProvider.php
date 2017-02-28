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
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('moderate', function ($user) {
            return $user->role === 'admin' || $user->role === 'moderator';
        });

        Gate::define('send-email', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-users', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('edit-question', function ($user, $question) {
            return $user->role === 'admin' || $user->role === 'moderator' || $question->author->id === $user->id;
        });

        Gate::define('edit-answer', function ($user, $answer) {
            return $user->role === 'admin' || $user->role === 'moderator' || $answer->author->id === $user->id;
        });

        Gate::define('edit-comment', function ($user, $comment) {
            return $user->role === 'admin' || $user->role === 'moderator' || $comment->author->id === $user->id;
        });
    }
}
