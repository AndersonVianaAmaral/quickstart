<?php

namespace App\Http\Controllers;

use App\Models\CastMember;
use Illuminate\Http\Request;

class CastMemberController extends Controller
{
    private $rules = [
        'name' => 'required|max:255|min:4',
        'type' => "required|in:1,2" /* . implode(',', [CastMember::TYPE_ACTOR,CastMember::TYPE_DIRECTOR])*/
    ];

    public function index()
    {
        return CastMember::all();
    }

    public function store(Request $request)
    {
        $this->Validate($request, $this->rules);
        $castmember = CastMember::create($request->all());
        $castmember->refresh();
        return $castmember;
    }

    public function show(CastMember $castmember)
    {
        return $castmember;
    }

    public function update(Request $request, CastMember $castmember)
    {
        $this->Validate($request, $this->rules);
        $castmember->update($request->all());
        return $castmember;
    }

    public function destroy(CastMember $castmember)
    {
        $castmember->delete();
        return response()->noContent();
    }
}
