<?php

namespace App\Model;

use App\Helper\StrHelper;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Thumbnail;

class Slide extends Model
{
    use Thumbnail;
    public $timestamps = false;
    public $file_dir_field_name = 'file_dir';//fájl elérérési könyvtár oszlopneve
    public $thumbnail_col_name =[ // ezeknek az oszlopnevekből csinál thumbnail
        'image'
    ];

    protected $fillable = [
        'slug',
        'image',
        'file_dir',
        'category_id',

        /*'title_hu',
        'content_hu',
        'title_en',
        'content_en',
        'title_de',
        'content_de',
        'title_jp',
        'content_jp',
        'title_ae',
        'content_ae',*/
    ];//*** Ha hozzá adnak egy új nyelvet akkor bele ír a fájba és kiegészíti

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

    public function galleries()
    {
        return $this->belongsToMany('App\Model\Gallery');
    }


    public function category(){
        return $this->belongsTo('App\Model\Category');
    }


    /**
     *
     * Kép alt értéke
     *
     * slide[subtitle], ha nincs akkor item[subtitle], ha az sincs akkor item[title]
     *
     * @param null $item
     * @return mixed|null
     */
    public function showAlt(ContentTypeBaseModel $item = null){

        if(!empty($this->subtitle)){
            return $this->subtitle;
        }

        if($item){

            if(!empty($item->subtitle)){
                return $item->subtitle;
            }

            return $item->title;

        }

        return null;

    }


    public function titleLang($lang = null){

        if(empty($lang)){
            $content = $this->content;
        }else{
            $content = $this->content($lang);
        }

        if(!empty($content)){
            if(empty($content->title)){
                if(!empty($content->first()->title)){
                    return $content->first()->title;
                }

            }else{
                return '';
                dd($content->title);
                return $content->title;
            }

        }else{
            return '';
        }

    }

    public function contentLang($lang = null){

        if(empty($lang)){
            $content = $this->content;
        }else{
            $content = $this->content($lang);
        }

        if(!empty($content)){
            if(empty($content->content)){
                if(!empty($content->first()->title)){
                    return $content->first()->content;
                }else{
                    return '';
                }

            }else{
                return '';
                return $content->content;
            }

        }else{
            return '';
        }

    }

    public function content($lang = null){
        if(empty($lang)){
            $lang = session('lang');
        }
        $out = $this->belongsTo('App\Model\SlideContent', 'id', 'slide_id')
                ->where('lang', $lang);

        return $out;
    }

}
