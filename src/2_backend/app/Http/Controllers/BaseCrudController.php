<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseCrudController extends Controller
{
    protected abstract function Model();
    protected abstract function RuleStore();
    protected abstract function RuleUpdate();

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
    public function show($id)
    {
        return $this->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $obj = $this->findOrFail($id);
        $validateData = $this->validate($request,$this->RuleUpdate());
        $obj->update($validateData);
        return $obj;
    }

    public function destroy($id)
    {
        $this->findOrFail($id)->delete();
        return response()->noContent();
    }
}
