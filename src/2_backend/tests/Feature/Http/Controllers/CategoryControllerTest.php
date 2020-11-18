<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestValidations;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations;

    public function MakeCategory() {
        $category = Category::create(['name'=>'XPTO', 'is_active'=>true]);
        $category->refresh();
        return $category;
    }

    public function testIndex()
    {
        $category = $this->MakeCategory();

        $response = $this->get(route('categories.index'));

        $response
            ->assertStatus(200)
            ->assertJson([$category->toArray()]);
    }

    public function testShow()
    {
        $category = $this->MakeCategory();

        $response = $this->get(route('categories.show',['category'=>$category->id]));

        $response
            ->assertStatus(200)
            ->assertJson($category->toArray());
    }

    public function testValidatorData()
    {
        $response = $this->json('POST',route('categories.store'),[]);
        $this->assertInvalidationFields($response, ['name'], 'validation.required', []);
        $response->assertJsonMissingValidationErrors(['is_active']);

        $response = $this->json('POST',route('categories.store'),['name'=>str_repeat('a',254), 'is_active'=>'a']);
        $this->assertInvalidationFields($response, ['is_active'], 'validation.boolean', []);

        $response = $this->json('PUT',route('categories.update',['category'=>$this->MakeCategory()->id]),['is_active'=>false]);
        $this->assertInvalidationFields($response,['name'],'validation.required', []);

        $response = $this->json('PUT',route('categories.update',['category'=>$this->MakeCategory()->id]),['is_active'=>'a', 'name'=>'birrr']);
        $this->assertInvalidationFields($response,['is_active'],'validation.boolean', []);
    }

    public function testSotre()
    {
        $category = $this->MakeCategory();
        $response = $this->json('PUT', route('categories.update',['category'=> $category->id]),[
            'name' => 'test',
            'is_active' => false
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'test'
            ]);
        $this->assertFalse($response->json('is_active'));

        $response = $this->json('POST', route('categories.store'),[
            'name' => 'test'
        ]);

        $category = Category::find($response->json('id'));

        $response
            ->assertStatus(201)
            ->assertJson($category->toArray());
        $this->assertTrue($response->json('is_active'));
        $this->assertNull($response->json('description'));

        $response = $this->json('POST', route('categories.store'),[
            'name' => 'test',
            'description' => 'description',
            'is_active' => false
        ]);

        $category = Category::find($response->json('id'));

        $response
        ->assertStatus(201)
        ->assertJson($category->toArray())
        ->assertJsonFragment([
            'is_active' => false,
            'description' => 'description'
        ]);
        $this->assertFalse($response->json('is_active'));
        $this->assertNotNull($response->json('description'));
    }

    public function testDelete(){
        $this->MakeCategory();
        $category = $this->MakeCategory();

        $response = $this->json('DELETE', route('categories.destroy',['category'=> $category->id]),[$category]);
        $response->assertStatus(204);
    }
}
