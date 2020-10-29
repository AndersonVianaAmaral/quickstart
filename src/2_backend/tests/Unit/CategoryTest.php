<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Gender;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testFillableAttributes()
    {
        Gender::create(['name' => 'test']);
        
        $fillable = ['name','description','is_active'];
        $category = new Category();
        $this->assertEquals($fillable, $category->getFillable());
    }

    public function testIfUsingTraits()
    {
        $traits = [
            SoftDeletes::class, 
            \App\Models\Traits\Uuid::class,
            \Illuminate\Database\Eloquent\Factories\HasFactory::class
        ];
        $categoryTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits, $categoryTraits);
    }

    public function testCats()
    {
        $casts = ['id' => 'string', 'deleted_at' => 'datetime'];
        $category = new Category();
        $this->assertEquals($casts, $category->getCasts());
    }

    public function testIncrementing()
    {
        $category = new Category();
        $this->assertFalse($category->incrementing);
    }

    public function testDates()
    {
        $dates = ['created_at','updated_at', 'deleted_at'];
        $category = new Category();

        foreach($dates as $date){
            $this->assertContains($date, $category->getDates());
        }
        
        $this->assertCount(count($dates),$category->getDates());
    }
}
