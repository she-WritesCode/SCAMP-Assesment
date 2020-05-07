<?php

namespace App\Http\Controllers\Api\V1\Categories;

use App\Category;
use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(Category::all(), 200);
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
            'description' => 'required|string',
        ];
        $request->validate($rules);

        $category = Category::create($request->all());

        return $this->showOne($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'nullable|string|max:225',
            'description' => 'nullable|string',
        ];

        $request->validate($rules);

        $category->fill([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($category->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $category->save();
        return $this->showOne($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->successResponse(null, 204);
    }
}
