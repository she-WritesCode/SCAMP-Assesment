<?php

namespace App\Http\Controllers\Api\V1\Permissions;

use App\Http\Controllers\Api\V1\ApiController;
use App\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PermissionController extends ApiController
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
    public function index()
    {
        return $this->showAll(Permission::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:225',
            'slug' => 'nullable|string|max:225',
        ];
        $request->validate($rules);

        $data = $request->all();
        $data['slug'] = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        $permission = Permission::create($data);

        return $this->showOne($permission, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return $this->showOne($permission, 200);
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
            'name' => 'nullable|string|max:225',
            'slug' => 'nullable|string|max:225',
        ];

        $request->validate($rules);

        $permission->fill([
            'name' => $request->name ?: $permission->name,
            'slug' => $request->slug ? Str::slug($request->slug) : $permission->slug,
        ]);

        if ($permission->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $permission->save();
        return $this->showOne($permission, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return $this->successResponse(null, 204);
    }
}
