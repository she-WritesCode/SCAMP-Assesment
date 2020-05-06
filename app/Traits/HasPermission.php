<?php

namespace App\Traits;

use App\Permission;
use App\Role;

/**
 * Has Permission Trait for Users
 */
trait HasPermission
{
    public function givePermissionTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        dd($permissions);
        if ($permissions == null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function withdrawPermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    public function refreshPermissions(...$permissions)
    {
        $this->permissions()->detach();
        return $this->givePermissionTo($permissions);
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission);
    }

    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->role as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    public function permissions()
    {
        return $this->roles();
        // return $this->belongsToMany(Permission::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasPermission($permission)
    {
        return (bool) $this->permissions()->where('slug', $permission->slug)->count();
    }

    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }
}
