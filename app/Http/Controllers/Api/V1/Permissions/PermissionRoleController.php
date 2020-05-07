<?php

namespace App\Http\Controllers\Api\V1\Permissions;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $rules = [
            'data' => 'array',
        ];

        $request->validate($rules);

        $roles = [];
        foreach ($request->data as $role) {
            $roles[] = (int) $role['id'];
        }

        $permission->roles()->sync($roles);

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
            'data' => 'array',
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
