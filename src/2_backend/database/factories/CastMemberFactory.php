<?php

namespace Database\Factories;

use App\Models\CastMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class CastMemberFactory extends Factory
{
    protected $model = CastMember::class;

    public function definition()
    {
        return [
            'name' => "nameXPTO",
            'type' => 1
        ];
    }
}
