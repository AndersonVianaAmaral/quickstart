<?php

namespace Tests\Feature\Models;

use App\Models\Gender;
use Facade\Ignition\DumpRecorder\DumpHandler;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GenderTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        Gender::create([ 'name'=> 'XPTO' ]);
        $genders = Gender::all();
        $genderKeys = array_keys($genders->first()->getAttributes());

        $this->assertCount(1, $genders); 
        $this->assertEqualsCanonicalizing(['id','name','created_at','updated_at','deleted_at', 'is_active'], $genderKeys);
    }

    public function testCreate(){
        $gender = Gender::create([
            'name'=>'test1'
        ]);
        $gender->refresh();
        
        $this->assertEquals('test1',$gender->name);
        $this->assertTrue($gender->is_active);

        $gender = Gender::create([
            'name'=>'test1'
        ]);
        $this->assertEquals('test1',$gender->name);

        $gender = Gender::create([
            'name'=>'test1',
            'is_active'=> false
        ]);
        $this->assertFalse($gender->is_active);
    }

    public function testEdit(){
        $gender = Gender::create([
            'name'=>'test1'
        ]);
        $gender->update([
            'name'=>'test'
        ]);
        $this->assertEquals('test', $gender->name);
    }

    public function testDelete(){
        Gender::create([ 'name'=> 'XPTO' ]);
        Gender::create([ 'name'=> 'XPTO1' ]);

        $genders = Gender::all();
        $genders->first()->delete();

        $this->assertEquals(1, $genders->where('deleted_at', null)->count());
    }
}
