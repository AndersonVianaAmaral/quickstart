<?php

namespace Tests\Unit\Models;

use App\Models\CastMember;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;

class CastMembersTest extends TestCase
{
    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new CastMember();
    }

    public function testFillableAttributes()
    {
        $fillable = ['name','type'];
        $this->assertEquals($fillable, $this->category->getFillable());
    }

    public function testIfUsingTraits()
    {
        $traits = [
            SoftDeletes::class,
            \App\Models\Traits\Uuid::class,
            \Illuminate\Database\Eloquent\Factories\HasFactory::class
        ];
        $categoryTraits = array_keys(class_uses(CastMember::class));
        $this->assertEquals($traits, $categoryTraits);
    }

    public function testCats()
    {
        $casts = ['id' => 'string', 'deleted_at' => 'datetime'];
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
