<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ThumbnailSize extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'prefix',
        'width',
        'height',
        'description',
    ];
}
