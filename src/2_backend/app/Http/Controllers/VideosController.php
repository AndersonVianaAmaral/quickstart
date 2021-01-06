<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use Illuminate\Http\Request;

class VideosController extends BaseCrudController
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'title' => 'required|max:255',
            'description' => 'required',
            'year_launched' => 'required|date_format:Y',
            'opened' => 'boolean',
            'rating' => 'required|in:'.implode(',',Videos::RATING_LIST),
            'duration' => 'required|integer',
            'categories_id' => 'required|array|exists:categories,id'
        ];
    }

    public function store(Request $request)
    {
        $data = $this->Validate($request, $this->RuleStore());
        $model = $this->Model()::create($data);
        $model->categories()->sync($request->get('categories_id'));
        $model->refresh();
        return $model;
    }

    public function update(Request $request, $id)
    {
        $obj = $this->findOrFail($id);
        $validateData = $this->validate($request,$this->RuleUpdate());
        $obj->update($validateData);
        return $obj;
    }

    protected function Model()
    {
        return Videos::class;
    }

    protected function RuleStore()
    {
        return $this->rules;
    }

    protected function RuleUpdate()
    {
        return $this->rules;
    }
}
