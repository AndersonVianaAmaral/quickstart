<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    public function testFillableAttributes()
    {
        $fillable = ['name','description','is_active'];
        $this->assertEquals($fillable, $this->category->getFillable());
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
        $casts = ['id' => 'string', 'deleted_at' => 'datetime', 'is_active'=>'boolean'];
        $this->assertEquals($casts, $this->category->getCasts());
    }

    public function testIncrementing()
    {
        $this->assertFalse($this->category->incrementing);
    }

    public function testDates()
    {
        $dates = ['created_at','updated_at', 'deleted_at'];

        foreach($dates as $date){
            $this->assertContains($date, $this->category->getDates());
        }
        
        $this->assertCount(count($dates),$this->category->getDates());
    }
}
