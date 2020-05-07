<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $roles = $user->roles;

        return $this->showAll($roles, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $rules = [
            'data' => 'array',
        ];

        $request->validate($rules);

        $permissions = [];
        foreach ($request->data as $permission) {
            $permissions[] = (int) $permission['id'];
        }

        $user->permissions()->sync($permissions);

        return $this->showAll($user->permissions, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $rules = [
            'data' => 'array',
        ];

        $request->validate($rules);

        $permissions = [];
        foreach ($request->data as $permission) {
            $permissions[] = (int) $permission['id'];
        }

        $user->permissions()->detach($permissions);

        return $this->successResponse(null, 204);
    }
}
