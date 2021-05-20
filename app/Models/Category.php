<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Category extends Model
{
    use SoftDeletes, Traits\Uuid;
    protected $fillable = ['name', 'description', 'is_active'];
    protected $dates = ['deleted_at'];
    //id era convertido como int, então forçar a conversão para string
    protected $casts = [
        'id' => 'string'
    ];
}