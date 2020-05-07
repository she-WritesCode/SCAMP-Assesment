<?php

namespace App\Http\Controllers\Api\V1\Permissions;

use App\Http\Controllers\Api\V1\ApiController as Controller;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Permission::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Permission $permission)
    {
        $roles = $permission->roles;

        return $this->showAll($roles, 200);
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Permission $permission)
    {
        $rules = [
            'data' => 'required|array',
        ];

        $request->validate($rules);

        $roles = [];
        foreach ($request->data as $role) {
            $roles[] = (int) $role['id'];
        }

        $permission->roles()->syncWithoutDetaching($roles);

        return $this->showAll($permission->roles, 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission, Role $role = null)
    {
        $permission->roles()->sync($role->id);

        return $this->showAll($permission->roles, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Permission $permission)
    {
        $rules = [
            'data' => 'required|array',
        ];

        $request->validate($rules);

        $roles = [];
        foreach ($request->data as $role) {
            $roles[] = (int) $role['id'];
        }

        $permission->roles()->detach($roles);

        return $this->successResponse(null, 204);;
    }
}
