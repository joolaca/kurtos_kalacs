<?php

namespace App\Model;

use App\Helper\StrHelper;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public $timestamps = false;



    protected $fillable = [
        'title',
        'slug',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();


        static::creating(function($item){
            $item->slug = StrHelper::slug($item->title, '_');
        });

    }


    public function slides(){
        return $this->belongsToMany('App\Model\Slide');
    }

    /** Amikor egy menühöz hozzárendelünk egy galériát
     * akkor ezeket a választhatjuk ki hogy milyen módon rendelelődjön FE en
     * admin/menu/1/edit
     * @return array
     */
    public function getAttachType(){
        return [
            'bootstrap_gallery' => 'Bootstrap Gallery',
            'slider_full_with' => 'Teljes képernyő széles slider',
        ];
    }
}
