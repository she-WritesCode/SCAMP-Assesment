<?php

namespace App\Http\Controllers\Api\V1\Roles;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Role $role)
    {
        $users = $role->users;

        return $this->showAll($users, 200);
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

        $user = [];
        foreach ($request->data as $user) {
            $users[] = (int) $user['id'];
        }

        $role->users()->sync($users);

        return $this->showAll($role->users, 200);
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

        $user = [];
        foreach ($request->data as $user) {
            $users[] = (int) $user['id'];
        }

        $role->users()->detach($users);

        return $this->successResponse(null, 204);
    }
}
