<?php

namespace App\Http\Controllers\Api\V1\Roles;

use App\Http\Controllers\Api\V1\ApiController as Controller;
use App\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Role $role)
    {
        $permissions = $role->permissions;

        return $this->showAll($permissions, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $rules = [
            'data' => 'array',
        ];

        $request->validate($rules);

        $permission = [];
        foreach ($request->data as $permission) {
            $permissions[] = (int) $permission['id'];
        }

        $role->permissions()->sync($permissions);

        return $this->showAll($role->permissions, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Role $role)
    {
        $rules = [
            'data' => 'array',
        ];

        $request->validate($rules);

        $permission = [];
        foreach ($request->data as $permission) {
            $permissions[] = (int) $permission['id'];
        }

        $role->permissions()->detach($permissions);

        return $this->successResponse(null, 204);
    }
}
