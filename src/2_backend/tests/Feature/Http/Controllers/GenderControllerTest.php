<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Gender;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GenderControllerTest extends TestCase
{
    use DatabaseMigrations;

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
        
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonMissingValidationErrors(['is_active'])
            ->assertJsonFragment([\Lang::get('validation.required',['attribute'=>'name'])]);
        
        $response = $this->json('POST',route('genders.store'),['name'=>str_repeat('a',254), 'is_active'=>'a']);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['is_active'])
            ->assertJsonFragment([\Lang::get('validation.boolean',['attribute'=>'is active'])]);      

        $response = $this->json('PUT',route('genders.update',['gender'=>$this->MakeGender()->id]),['is_active'=>'a']);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name','is_active'])
            ->assertJsonFragment([
                'errors' =>[
                    'name' => [\Lang::get('validation.required',['attribute'=>'name'])],
                    'is_active' => [\Lang::get('validation.boolean',['attribute'=>'is active'])]
                ]
            ]);
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
