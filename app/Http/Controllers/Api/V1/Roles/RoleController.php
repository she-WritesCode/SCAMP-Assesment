<?php

namespace App\Http\Controllers\Api\V1\Roles;

use App\Http\Controllers\Api\V1\ApiController;
use App\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RoleController extends ApiController
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
    public function index()
    {
        return $this->showAll(Role::all(), 200);
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

        $role = Role::create($data);

        return $this->showOne($role, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $this->showOne($role, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $rules = [
            'name' => 'nullable|string|max:225',
            'slug' => 'nullable|string|max:225',
        ];

        $request->validate($rules);

        $role->fill([
            'name' => $request->name ?: $role->name,
            'slug' => $request->slug ? Str::slug($request->slug) : $role->slug,
        ]);

        if ($role->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $role->save();
        return $this->showOne($role, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return $this->successResponse(null, 204);
    }
}
