<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'lang',
    ];
}
