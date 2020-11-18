<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Gender;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestValidations;

class GenderControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations;

    public function MakeGender()
    {
        $gender = Gender::create(['name'=>'Gender X']);
        $gender->refresh();
        return $gender;
    }

    public function testGetAll()
    {
        $gender = $this->MakeGender();
        $response = $this->get(route('genders.index'));
        $response
            ->assertStatus(200)
            ->assertJson([$gender->toArray()]);
    }

    public function testShow()
    {
        $gender = $this->MakeGender();

        $response = $this->get(route('genders.show',['gender'=>$gender->id]));

        $response
            ->assertStatus(200)
            ->assertJson($gender->toArray());
    }

    public function testDelete(){
        $this->MakeGender();
        $gender = $this->MakeGender();

        $response = $this->json('DELETE', route('genders.destroy',['gender'=> $gender->id]),[$gender]);
        $response->assertStatus(204);
    }

    public function testValidatorData()
    {
        $response = $this->json('POST',route('genders.store'),[]);
        $this->assertInvalidationFields($response,['name'],'validation.required', []);
        $response->assertJsonMissingValidationErrors(['is_active']);

        $response = $this->json('POST',route('genders.store'),['name'=>str_repeat('a',254), 'is_active'=>'a']);
        $this->assertInvalidationFields($response,['is_active'],'validation.boolean', []);

        $response = $this->json('PUT',route('genders.update',['gender'=>$this->MakeGender()->id]),['is_active'=>'a', 'name'=>'birrr']);
        $this->assertInvalidationFields($response,['is_active'],'validation.boolean', []);

        $response = $this->json('PUT',route('genders.update',['gender'=>$this->MakeGender()->id]),[]);
        $this->assertInvalidationFields($response,['name'],'validation.required', []);
    }

    public function testSotre()
    {
        $gender = $this->MakeGender();
        $response = $this->json('PUT', route('genders.update',['gender'=> $gender->id]),[
            'name' => 'test',
            'is_active' => false
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'test'
            ]);
        $this->assertFalse($response->json('is_active'));

        $response = $this->json('POST', route('genders.store'),[
            'name' => 'test'
        ]);

        $gender = Gender::find($response->json('id'));

        $response
            ->assertStatus(201)
            ->assertJson($gender->toArray());
        $this->assertTrue($response->json('is_active'));

        $response = $this->json('POST', route('genders.store'),[
            'name' => 'test',
            'is_active' => false
        ]);

        $gender = Gender::find($response->json('id'));

        $response
        ->assertStatus(201)
        ->assertJson($gender->toArray())
        ->assertJsonFragment([
            'is_active' => false
        ]);
        $this->assertFalse($response->json('is_active'));
    }
}
