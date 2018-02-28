<?php

namespace App\Model;

use App\Helper\StrHelper;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'lang',
        'slug',
        'related_id',
        'model',
        'type',
        'category_id',
        'sequence',
    ];

    public function contents(){
        return $this->belongsToMany('App\Model\Content','content_menu', 'rendered_id');
    }

    public function category(){
        return $this->belongsTo('App\Model\MenuCategory');
    }


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
        $count = $this->where('slug', 'like', $slug)->where('id', '!=', $id)->count();
        if($count != 0){
            $slug .= '_'.(string)((int)$count +1);
        }

        $this->attributes['slug'] = $slug;
    }



    public function renderOtherMenuButtons(){

        $lift_up = '<a class="btn btn-success menu_change_sequence"
            data-menu-id="'.$this->id.'"
            data-menu-sequence="'.$this->sequence.'"
            data-action = "lift_up"
            >
            <i class="fa fa-arrow-up" aria-hidden="true"></i>
            </a>';
        $lift_down = '<a class="btn btn-success menu_change_sequence"
            data-menu-id="'.$this->id.'"
            data-menu-sequence="'.$this->sequence.'"
            data-action = "lift_down"
            >
            <i class="fa fa-arrow-down" aria-hidden="true"></i>
            </a>';
        return $lift_up . $lift_down;
    }

}
