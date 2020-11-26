<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseCrudController extends Controller
{
    protected abstract function Model();
    protected abstract function RuleStore();

    public function index()
    {
        return $this->Model()::all();
    }

    public function store(Request $request)
    {
        $data = $this->Validate($request, $this->RuleStore());
        $model = $this->Model()::create($data);
        $model->refresh();
        return $model;
    }

    protected function findOrFail($id)
    {
        $model = $this->Model();
        $key = (new $model)->getRouteKeyName();
        return $this->Model()::where($key,$id)->firstOrFail();
    }
    // public function show(Category $category)
    // {
    //     return $category;
    // }

    // public function update(Request $request, Category $category)
    // {
    //     $this->Validate($request, $this->rules);
    //     $category->update($request->all());
    //     return $category;
    // }

    // public function destroy(Category $category)
    // {
    //     $category->delete();
    //     return response()->noContent();
    // }
}
