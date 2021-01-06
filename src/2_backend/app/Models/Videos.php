<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Videos extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \App\Models\Traits\Uuid;

    const RATING_LIST = ['L','10','12','14','16','18'];

    protected $fillable = [
            'title',
            'description',
            'year_launched',
            'opened',
            'rating',
            'duration'
        ];
    protected $dates = ['deleted_at'];
    protected $casts = [
        'id'=>'string',
        'opened'=>'boolean',
        'year_launched'=>'integer',
        'duration'=>'integer'
    ];
    public $incrementing = false;

}
