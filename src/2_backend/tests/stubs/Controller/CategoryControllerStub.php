<?php

namespace Tests\stubs\Controller;

use App\Http\Controllers\BaseCrudController;
use Tests\stubs\Model\CategoryStub;

class CategoryControllerStub extends BaseCrudController
{
    protected function Model()
    {
        return CategoryStub::class;
    }

    protected function RuleStore()
    {
        return [
            'name' => 'required|max:255|min:4',
            'is_active' => 'boolean',
            'description' => 'nullable'
        ];
    }

    protected function RuleUpdate(){
        return [
            'name' => 'required|max:255|min:4',
            'description' => 'nullable'
        ];
    }
}
