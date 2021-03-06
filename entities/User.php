<?php

namespace Grimm;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @property mixed  id
 * @property mixed  name
 * @property mixed  email
 * @property string password
 * @property mixed  api_only
 * @property string api_token
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $permissions = null;

    /**
     * true if the user has all permissions
     * field is populated by the call of hasPermission()
     *
     * @var bool
     */
    protected $hasAllPermissions = false;

    /**
     * @param $permission
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        if ($this->permissions === null) {
            $this->hydratePermissions();
        }

        return $this->hasAllPermissions || in_array($permission, $this->permissions);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Hydrates permission flags
     *
     * @return void
     */
    private function hydratePermissions()
    {
        $this->permissions = [];
        $this->hasAllPermissions = false;

        /** @var Role[] $roles */
        $roles = $this->roles()->getQuery()->with('permissions')->get();

        foreach ($roles as $role) {
            if ($role->has_all_permissions) {
                $this->hasAllPermissions = true;

                return;
            }

            foreach ($role->permissions as $permission) {
                $this->permissions[] = $permission->name;
            }
        }
    }
}
