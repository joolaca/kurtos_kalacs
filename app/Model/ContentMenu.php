<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContentMenu extends Model
{
    public $timestamps = false;
    public $table = 'content_menu';

    protected $fillable = [
        'menu_id',
        'related_id',
        'content_controller',
        'type',
    ];
}
