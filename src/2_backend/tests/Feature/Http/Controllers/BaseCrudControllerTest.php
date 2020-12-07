<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\BaseCrudController;
use App\Models\Category;
use Tests\stubs\Controller\CategoryControllerStub;
use Tests\stubs\Model\CategoryStub;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use ReflectionClass;

class BaseCrudControllerTest extends TestCase
{
    private $controller;


    protected function setUp(): void
    {
        parent::setUp();
        CategoryStub::makeTable();
        $this->controller = new CategoryControllerStub();
    }
    protected function tearDown(): void
    {
        CategoryStub::dropTable();
        parent::tearDown();
    }

    public function testIndex()
    {
        $category = CategoryStub::create(['name' => 'birrr', 'description'=>'xpto']);
        $response = $this->controller->index()->toArray();
        $this->assertEquals([$category->toArray()], $response);
    }

    public function testStoreValidation()
    {
        $this->expectException(ValidationException::class);
        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn(['name'=>'']);

        $this->controller->store($request);
    }

    public function testStore()
    {
        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn(['name'=>'BIRR']);
        $response = $this->controller->store($request);

        $this->assertEquals(
            CategoryStub::find(1)->toArray(),
            $response->toArray()
        );
    }

    public function testFindOrFail()
    {
        $category = CategoryStub::create(['name' => 'birrr', 'description'=>'xpto']);
        $reflection = new ReflectionClass(BaseCrudController::class);
        $reflectionMethod = $reflection->getMethod('findOrFail');
        $reflectionMethod->setAccessible(true);
        $result = $reflectionMethod->invokeArgs($this->controller, [$category->id]);
        $this->assertInstanceOf(CategoryStub::class, $result);
    }

    public function testFindOrFailExceptionWhenIdIsInvalid()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $reflection = new ReflectionClass(BaseCrudController::class);
        $reflectionMethod = $reflection->getMethod('findOrFail');
        $reflectionMethod->setAccessible(true);
        $result = $reflectionMethod->invokeArgs($this->controller, [0]);
        $this->assertInstanceOf(CategoryStub::class, $result);
    }

    public function testShow()
    {
        $category = CategoryStub::create(['name' => 'birrr', 'description'=> 'birrrrrrrrrr']);
        $result = $this->controller->show($category->id);
        $this->assertEquals($result->toArray(), CategoryStub::find(1)->toArray());
    }

    public function testUpdate()
    {
        $category = CategoryStub::create(['name' => 'birrr', 'description'=> 'birrrrrrrrrr']);
        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn(['name' => 'anderson', 'description'=> 'birrrrrrrrrr']);
        $result = $this->controller->update($request,$category->id);
        $this->assertEquals($result->toArray(), CategoryStub::find(1)->toArray());
    }

    public function testDestroy()
    {
        $category = CategoryStub::create(['name' => 'birrr', 'description'=> 'birrrrrrrrrr']);
        $result = $this->controller->destroy($category->id);
        $this->createTestResponse($result)->assertStatus(204);
    }
}
