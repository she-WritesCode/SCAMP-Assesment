<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Api\V1\ApiController;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(User::all(), 200);
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
            'email' => 'required|email|max:225|unique:users',
            'password' => 'required|confirmed|min:6',
            'role_id' => 'nullable|integer',
        ];

        $request->validate($rules);

        $data = $request->all(['name', 'email', 'password']);
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        $role_id = $request->role_id ?: Role::where('slug', 'sales-person')->first()->id;

        $user->roles()->attach($role_id);

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'nullable|string|max:225',
            'email' => 'nullable|email|max:225|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
        ];

        $request->validate($rules);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
            return $user;
        }

        if ($user->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $user->save();
        return $this->showOne($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->successResponse('user deleted successfully', 204);
    }
}


// public function create(Request $request)
// {
//     $rules = [
//         'data.attributes.name' => 'required|string|max:225',
//         'data.attributes.email' => 'required|email|max:225|unique:users',
//         'data.attributes.password' => 'required|confirmed|min:6',
//         'data.relationships.role[].id' => 'nullable|integer',
//         'data.relationships.role[].type' => 'nullable|in:roles',
//     ];

//     $request->validate($rules);

//     $data['name'] = $request->data['attributes']['name'];
//     $data['email'] = $request->data['attributes']['email'];
//     $data['password'] = bcrypt($request->data['attributes']['password']);
//     $user = User::create($data);

//     foreach ($request->data['relationships']['roles'] as $role) {
//         $role_id[] = $role['id'];
//     }
//     $role_id = ($role_id == []) ? $role_id : Role::where('slug', 'sales-person')->first()->id;

//     $user->roles()->attach($role_id);

//     return $this->showOne($user, 201);
// }
