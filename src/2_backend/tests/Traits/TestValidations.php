<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Testing\TestResponse;

trait TestValidations
{
    protected function assertInvalidationFields(TestResponse $response, array $fields, string $rule, array $ruleParams = [])
    {
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors($fields);

        foreach($fields as $field)
        {
            $fieldName = str_replace('_',' ', $field);
            $response
                ->assertJsonFragment([
                    \Lang::get($rule,['attribute'=>$fieldName] + $ruleParams)
                ]);
        }
    }
}
