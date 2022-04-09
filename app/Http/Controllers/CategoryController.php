<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display categories with children.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::with('children')->whereNull('parent_id')->get();;
    }

    /**
     * Display a list of categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if($request->query('limit') && is_numeric($request->query('limit'))) {
            return Category::paginate($request->query('limit'));
        }

        if($request->query('slug')) {
            return Category::where('slug', "=", $request->query('slug'))->with('children')->first();
        }

        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        return Category::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        return Category::where('id', $category)->with('children')->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        return $category->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        return $category->delete();
    }
}
