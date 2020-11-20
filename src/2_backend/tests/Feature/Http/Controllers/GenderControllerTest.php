<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Gender;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class GenderControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations, TestSaves;

    private $gender;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gender = Gender::create(['name'=>'XPTO', 'is_active'=>true]);
        $this->gender->refresh();

    }
    public function testGetAll()
    {
        $response = $this->get(route('genders.index'));
        $response
            ->assertStatus(200)
            ->assertJson([$this->gender->toArray()]);
    }

    public function testShow()
    {
        $response = $this->get(route('genders.show',['gender'=>$this->gender->id]));

        $response
            ->assertStatus(200)
            ->assertJson($this->gender->toArray());
    }

    public function testDelete(){
        $response = $this->json('DELETE', route('genders.destroy',['gender'=> $this->gender->id]),[$this->gender]);
        $response->assertStatus(204);
    }

    public function testValidatorData()
    {
        $response = $this->json('POST',route('genders.store'),[]);
        $this->assertInvalidationFields($response,['name'],'validation.required', []);
        $response->assertJsonMissingValidationErrors(['is_active']);

        $response = $this->json('POST',route('genders.store'),['name'=>str_repeat('a',254), 'is_active'=>'a']);
        $this->assertInvalidationFields($response,['is_active'],'validation.boolean', []);

        $response = $this->json('PUT',route('genders.update',['gender'=>$this->gender->id]),['is_active'=>'a', 'name'=>'birrr']);
        $this->assertInvalidationFields($response,['is_active'],'validation.boolean', []);

        $response = $this->json('PUT',route('genders.update',['gender'=>$this->gender->id]),[]);
        $this->assertInvalidationFields($response,['name'],'validation.required', []);
    }

    public function testSotre()
    {
        $this->assertStore(['name'=>'test'],['name'=>'test', 'is_active' => true, 'deleted_at' => null]);
        $this->assertStore(['name'=>'test', 'is_active' => false],['name'=>'test', 'is_active' => false, 'deleted_at' => null]);
    }

    public function testUpdate()
    {
        $this->assertInvalidationInUpdateAction(['name'=>''],'validation.required');
        $this->assertInvalidationInUpdateAction(['is_active'=>'a'],'validation.boolean');
        $this->assertUpdate(['name' => 'test'],['name' => 'test', 'is_active'=> true, 'deleted_at'=> null]);
    }

    protected function routeStore()
    {
        return route('genders.store');
    }

    protected function routeUpdate()
    {
        return route('genders.update',['gender'=> $this->gender->id]);
    }

    protected function model()
    {
        return Gender::class;
    }
}
