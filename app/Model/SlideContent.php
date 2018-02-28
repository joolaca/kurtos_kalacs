<?php

namespace App\Model;

use App\Helper\StrHelper;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Thumbnail;

class SlideContent extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'slide_id',
        'slug',
        'lang',
        'content',
        'title',
        'slug',
    ];



}
