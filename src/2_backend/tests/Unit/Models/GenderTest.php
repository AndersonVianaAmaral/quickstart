<?php

namespace Tests\Unit\Models;

use App\Models\Gender;
use Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenderTest extends TestCase
{
    private $gender;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gender = new Gender();
    }

    public function testFillableAttributes()
    {
        $fillable = ['name','is_active'];
        $this->assertEquals($fillable, $this->gender->getFillable());
    }

    public function testIfUsingTraits()
    {
        $traits = [
            SoftDeletes::class, 
            \App\Models\Traits\Uuid::class,
            \Illuminate\Database\Eloquent\Factories\HasFactory::class
        ];
        $genderTraits = array_keys(class_uses(Gender::class));
        $this->assertEqualsCanonicalizing($traits, $genderTraits);
    }

    public function testCats()
    {
        $casts = ['id' => 'string', 'deleted_at' => 'datetime', 'is_active'=>'boolean'];
        $this->assertEquals($casts, $this->gender->getCasts());
    }

    public function testIncrementing()
    {
        $this->assertFalse($this->gender->incrementing);
    }

    public function testDates()
    {
        $dates = ['created_at','updated_at', 'deleted_at'];

        foreach($dates as $date){
            $this->assertContains($date, $this->gender->getDates());
        }
        
        $this->assertCount(count($dates),$this->gender->getDates());
    }
}
