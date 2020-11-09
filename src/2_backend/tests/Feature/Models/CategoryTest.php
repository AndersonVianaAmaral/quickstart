<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        Category::create([ 'name'=> 'XPTO' ]);
        $categories = Category::all();
        $categoryKeys = array_keys($categories->first()->getAttributes());

        $this->assertCount(1, $categories); 
        $this->assertEqualsCanonicalizing(['id','name','description','created_at','updated_at','deleted_at', 'is_active'], $categoryKeys);
    }

    public function testCreate(){
        $category = Category::create([
            'name'=>'test1'
        ]);
        $category->refresh();
        
        $this->assertEquals('test1',$category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);

        $category = Category::create([
            'name'=>'test1',
            'description'=>'birrr'
        ]);
        $this->assertEquals('birrr',$category->description);

        $category = Category::create([
            'name'=>'test1',
            'description'=>'birrr',
            'is_active'=> false
        ]);
        $this->assertFalse($category->is_active);
    }

    public function testEdit(){
        $category = Category::create([
            'name'=>'test1',
            'description'=>'test'
        ]);
        $category->update([
            'name'=>'test',
            'description'=>'test1'
        ]);
        $this->assertEquals('test', $category->name);
        $this->assertEquals('test1', $category->description);
    }
}
