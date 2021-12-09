<?php

namespace App\Providers;

use Grimm\Permission;
use Grimm\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'Grimm\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (!$this->app->runningInConsole()) {
            $this->registerRolesAsGates();
        }

        Passport::routes();

        $this->registerChannelGuard();
    }

    private function registerRolesAsGates()
    {
        $groups = Permission::selectRaw("SUBSTRING_INDEX(`name`, '.', 1) as topic, GROUP_CONCAT(name) as permissions")->groupBy('topic')->get();

        /** @var Permission $permission */
        foreach ($groups as $permissionGroup) {
            $permissions = explode(",", $permissionGroup->permissions);
            foreach ($permissions as $permission) {
                Gate::define($permission, function (User $user) use ($permission) {
                    return $user->hasPermission($permission);
                });
            }

            Gate::define($permissionGroup->topic . '.*', function (User $user) use ($permissions) {
                foreach ($permissions as $permission) {
                    if ($user->hasPermission($permission)) {
                        return true;
                    }
                }
                return false;
            });
        }
    }

    private function registerChannelGuard()
    {
        Auth::extend('channel', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...

            return new class implements Guard {

                public function check()
                {
                    return true;
                }

                public function guest()
                {
                    // TODO: Implement user() method.
                }

                public function user()
                {
                    // TODO: Implement user() method.
                    return true;
                }

                public function id()
                {
                    // TODO: Implement id() method.
                }

                public function validate(array $credentials = [])
                {
                    // TODO: Implement validate() method.
                }

                public function setUser(Authenticatable $user)
                {
                    // TODO: Implement setUser() method.
                }
            };
        });
    }
}
