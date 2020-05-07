<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Api\V1\ApiController as Controller;
use App\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
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

        $roles = [];
        foreach ($request->data as $role) {
            $roles[] = (int) $role['id'];
        }

        $user->roles()->sync($roles);

        return $this->showAll($user->roles, 200);
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

        $roles = [];
        foreach ($request->data as $role) {
            $roles[] = (int) $role['id'];
        }

        $user->roles()->detach($roles);

        return $this->successResponse(null, 204);
    }
}
