<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $this->Validate($request,[
            'name' => 'required | max:255 | min:4',
            'is_active' => 'boolean' 
        ]);

        return Category::create($request->all());
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
    }

    public function destroy(Category $category)
    {
    }
}
