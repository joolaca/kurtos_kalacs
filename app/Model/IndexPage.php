<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IndexPage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'lang',
        'type',
        'gallery_id',
        'slide_id',
        'title',
        'content',
        'description',
        'href',
        'href2',
    ];


    public function slide(){
        return $this->belongsTo('App\Model\Slide');
    }
}