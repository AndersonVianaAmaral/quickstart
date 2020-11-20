<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations, TestSaves;

    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::create(['name'=>'XPTO', 'is_active'=>true]);
        $this->category->refresh();

    }

    public function testIndex()
    {
        $response = $this->get(route('categories.index'));

        $response
            ->assertStatus(200)
            ->assertJson([$this->category->toArray()]);
    }

    public function testShow()
    {
        $response = $this->get(route('categories.show',['category'=>$this->category->id]));

        $response
            ->assertStatus(200)
            ->assertJson($this->category->toArray());
    }

    public function testValidatorDataStore()
    {
        $dataWithoutName = ['name' => ''];
        $this->assertInvalidationInStoreAction($dataWithoutName,'validation.required');

        $dataWithoutValidBoolean = ['is_active'=>'a'];
        $this->assertInvalidationInStoreAction($dataWithoutValidBoolean,'validation.boolean');

        $dataWithoutValidString = ['name' => str_repeat('a',256)];
        $this->assertInvalidationInStoreAction($dataWithoutValidString,'validation.max.string', ['max'=>255]);
    }

    public function testValidatorDataUpdate()
    {
        $this->assertInvalidationInUpdateAction(['name'=>''],'validation.required');
        $this->assertInvalidationInUpdateAction(['is_active'=>'a'],'validation.boolean');
        $this->assertUpdate(['name' => 'test'],['name' => 'test', 'description'=> null, 'is_active'=> true, 'deleted_at'=> null]);
    }

    public function testSotre()
    {
        $this->assertStore(['name'=>'test'],['name'=>'test', 'description' => null, 'is_active' => true, 'deleted_at' => null]);
        $this->assertStore(['name'=>'test', 'is_active' => false, 'description'=> 'birr'],['name'=>'test', 'description' => 'birr', 'is_active' => false, 'deleted_at' => null]);
    }

    public function testDelete()
    {
        $response = $this->json('DELETE', route('categories.destroy',['category'=> $this->category->id]),[$this->category]);
        $response->assertStatus(204);
    }

    protected function routeStore()
    {
        return route('categories.store');
    }

    protected function routeUpdate()
    {
        return route('categories.update',['category'=> $this->category->id]);
    }

    protected function model()
    {
        return Category::class;
    }
}
