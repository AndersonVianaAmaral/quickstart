<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CastMember extends Model
{
    use SoftDeletes;
    use \App\Models\Traits\Uuid;
    use HasFactory;

    protected $fillable = ['name','type'];
    protected $dates = ['deleted_at'];
    protected $casts = [
        'id' => 'string'
    ];
    public $incrementing = false;
}
