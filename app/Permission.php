<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $fillable = [
        'name',
        'slug'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
