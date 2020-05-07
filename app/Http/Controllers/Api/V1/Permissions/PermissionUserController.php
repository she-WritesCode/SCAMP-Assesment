<?php

namespace App\Http\Controllers\Api\V1\Permissions;

use App\Http\Controllers\Api\V1\ApiController as Controller;
use App\Permission;
use Illuminate\Http\Request;

class PermissionUserController extends Controller
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
        $users = $permission->users;

        return $this->showAll($users, 200);
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

        $userss = [];
        foreach ($request->data as $users) {
            $userss[] = (int) $users['id'];
        }

        $permission->userss()->sync($userss);

        return $this->showAll($permission->userss, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission $pernission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Permission $permission)
    {
        $rules = [
            'data' => 'array',
        ];

        $request->validate($rules);

        $userss = [];
        foreach ($request->data as $users) {
            $userss[] = (int) $users['id'];
        }

        $permission->userss()->detach($userss);

        return $this->successResponse(null, 204);
    }
}
