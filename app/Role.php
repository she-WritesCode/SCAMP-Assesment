<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $fillable = [
        'name',
        'slug'
    ];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
