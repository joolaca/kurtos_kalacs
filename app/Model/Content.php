<?php

namespace App\Model;

use App\Helper\StrHelper;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'lang',
        'lead',
    ];




    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = empty($value) ? StrHelper::slug($this->attributes['name'], '_') : StrHelper::slug($value, '_');
    }

    protected static function boot()
    {
        parent::boot();

        /*static::addGlobalScope('lang', function (Builder $builder) {
            $builder->where('language_id', session('language_id'));
        });*/

        static::creating(function($item){
            if (empty($item->slug))
            {
                //$this->attributes['slug'] = StrHelper::slug($value, '.');
                $item->slug = StrHelper::slug($item->title, '_');
            }
        });
    }

    public function getAttachType(){
        return [
            'normal' => "Normál"
        ];
    }
}
