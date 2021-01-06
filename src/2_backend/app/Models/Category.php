<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use \App\Models\Traits\Uuid;
    use HasFactory;

    protected $fillable = ['name','description','is_active'];
    protected $dates = ['deleted_at'];
    protected $casts = [
        'id' => 'string',
        'is_active'=> 'boolean'
    ];
    public $incrementing = false;

    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
