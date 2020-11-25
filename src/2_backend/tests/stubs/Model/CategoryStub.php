<?php

namespace Tests\stubs\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class CategoryStub extends Model
{
    //use HasFactory;

    protected $table = 'category_stubs';
    protected $fillable = ['name','description','is_active'];

    public static function makeTable()
    {
        \Schema::create('category_stubs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public static function dropTable()
    {
        \Schema::dropIfExists('category_stubs');
    }
}
