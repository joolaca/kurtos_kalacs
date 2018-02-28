<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'lang',
    ];
}
