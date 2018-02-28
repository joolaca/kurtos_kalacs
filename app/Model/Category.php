<?php

namespace App\Model;

use App\Helper\StrHelper;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'type',
        'slug',
        'description',
        'categorizable_id',
        'categorizable_type',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function($item){
            $item->slug = StrHelper::slug($item->title, '_');
        });
    }

    /**
     * Set slug attribute.
     *
     * @param string $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        if($value) {
            $slug = $value;
        } else {
            //$this->attributes['slug'] = StrHelper::slug($value, '.');
            $slug = StrHelper::slug($this->attributes['title'], '_');
        }
        $id = 0;
        if($this->id) {
            $id = $this->id;
        }
        $count = $this->where('slug', 'like', $slug.'%')->where('id', '!=', $id)->count();
        if($count != 0){
            $slug .= '_'.(string)((int)$count +1);
        }

        $this->attributes['slug'] = $slug;
    }

}
