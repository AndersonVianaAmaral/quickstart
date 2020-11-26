<?php

namespace App\Http\Controllers;

use App\Models\CastMember;
use Illuminate\Http\Request;

class CastMemberController extends Controller
{
    private $rules = [
        'name' => 'required|max:255|min:4',
        'type' => 'smallInteger'
    ];

    public function index()
    {
        return CastMember::all();
    }

    public function store(Request $request)
    {
        $this->Validate($request, $this->rules);
        $category = CastMember::create($request->all());
        $category->refresh();
        return $category;
    }

    public function show(CastMember $category)
    {
        return $category;
    }

    public function update(Request $request, CastMember $category)
    {
        $this->Validate($request, $this->rules);
        $category->update($request->all());
        return $category;
    }

    public function destroy(CastMember $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
