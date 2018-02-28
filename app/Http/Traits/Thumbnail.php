<?php

namespace App\Http\Traits;

use App\Http\Fields\ImageField;
use App\Model\ThumbnailSizes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Intervention\Image\Facades\Image;

trait Thumbnail
{

    private $model = 'thumbnail_sizes';

    /**
     * Modelben ha meghívják akkor generál egyéb képméreteket
     */
    public function generateThumbnail(){

        if(!isset($this->thumbnail_col_name)){
            Log::warning(get_class($this)." modelben nincs beállítva thumbnail_col_name");
            return;
        }

        foreach ($this->thumbnail_col_name as $file_field_name) {
            /*if(!isset($this->file_dir_field_name)){
                Log::warning(get_class($this)." modelben nincs beállítva file_dir_field_name");
                continue;
            }*/
//            $field = new \App\Http\Fields\ImageField('image');
//            $file_dir_field_name =$field->getPathCol();
            $file_dir_field_name = $this->file_dir_field_name;
            $dir = $this->$file_dir_field_name;
            $name = $this->$file_field_name;
            $path = public_path($dir.$name);
            if(!file_exists($path)){
                Log::warning(get_class($this)." nem létezik ez a fájl: ".$path);
                continue;
            }

            $this->generateThumbnailUsePath($path);

        }
    }

    /**
     * Fájl elérés alapján létrehozza a módosított képeket
     * @param string $path public_path("/file/slide/55/azta.jpg")
     */
    public function generateThumbnailUsePath($path){
        $sizes = $this->getThumbnailSizes();

        foreach ($sizes as $size) {
            $new_path = self::getPrefixFilePath($path,$size->prefix);
            if(file_exists($new_path)){ //Ha nem létezik
                continue;
            }else{
                Log::info($new_path);
            }

            $img = Image::make($path);
            $img = self::makeResize($img , $size);
            $img->save($new_path);

        }
    }

    /**
     * Elvégzi az átméretezést
     *
     * @param
     * @return
     */
    public static function makeResize($img, $size){

        if(!empty($size->width) && !empty($size->height) ){
            $img->fit($size->width , $size->height);
        }
        if(empty($size->width)){
            $img->heighten($size->height);
        }
        if(empty($size->height)){
            $img->widen($size->width);
        }
        return $img;
    }

    /**
     * Visszaadja hogy milyen felbontású képeket kell elkészíteni prefixel együtt
     * @return object ['width' => '400' , 'height' => null , 'prefix' => 'widen_']
     */
    public function getThumbnailSizes(){
        $model_str = '\\App\\Model\\ThumbnailSize';
        $model = new $model_str;

        return $model::all();
    }


    public static function getThumbnailSizeUsePrefix($prefix){
        $model_str = '\\App\\Model\\ThumbnailSize';
        $model = new $model_str;
        return $model::where('prefix' , $prefix)->first();
    }


    /**
     * Prefix alapján megváltoztatott fájl nevet ad vissza az eredeti elérés uttal
     * @param string $path    /file/slide/521/azta.jpg
     * @param string $prefix resize_
     * @return string  /file/slide/0/521/resize_azta.jpg
     */
    public static function getPrefixFilePath($path,$prefix){
		$path = str_replace("\\","/", $path);
        $path_array = explode('/', $path);
        $path_array[count($path_array)-1] = $prefix.end($path_array);
        $path = implode('/', $path_array);

        return $path;
    }


    /** Kapott fájl eléréséből töröli a tumbnailjeit
     * @param string $path fájl elérése
     */
    public function deleteThumbnail($path){
        $sizes = $this->getThumbnailSizes();
        foreach ($sizes as $size) {
            $t_path = self::getPrefixFilePath($path,$size->prefix);
            unlink(public_path($t_path));
        }
    }

    /**
     * Visszaadja index oldalon <td> ben megjelenítő képet
     * @param string $col annak a kép oszlopnak a neve amit meg akarunk jeleníteni
	 * @param string $thumb thumbnail méret neve
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    public function adminIndexImageUrl($col, $thumb = '100_50_'){

        $image_path = $this->file_dir.$thumb.$this->$col;
        if(!empty($col) && file_exists($image_path)){
            return url($image_path);
        }

        $image_path = $this->file_dir.$this->$col;
        if(file_exists($image_path)){
            return url($image_path);
        }
        return '';
    }

    /**
     * Visszaadja edit oldalon megjelenítő képet
     * @param $col annak a kép oszlopnak a neve amit meg akarunk jeleníteni
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    public function adminFormImageUrl($col){
        $image_path = $this->file_dir.'admin_form_'.$this->$col;
        if(file_exists($image_path)){
            return url($image_path);
        }

        $image_path = $this->file_dir.$this->$col;
        if(file_exists($image_path)){
            return url($image_path);
        }
        return null;
    }

    /**
     * Visszaadja egy kép egy thumbnail elérését
     * @param string $col annak a kép oszlopnak a neve amit meg akarunk jeleníteni
	 * @param string $thumb thumbnail méret neve
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    public function getImageThumbUrl($col, $thumb = 'admin_list_'){
        $image_path = $this->file_dir.$thumb.$this->$col;

        if(!empty($col) && file_exists($image_path)){
            return url($image_path);
        }

        $image_path = $this->file_dir.$this->$col;
        if(file_exists($image_path)){
            return url($image_path);
        }
        return null;
    }

    /**
     * Visszaadja egy kép egy thumbnail nevét
     * @param string $col annak a kép oszlopnak a neve amit meg akarunk jeleníteni
	 * @param string $thumb thumbnail méret neve
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    public function getImageThumbFileName($col, $thumb = 'admin_list_'){
        $image_path = $this->file_dir.$thumb.$this->$col;

        if(!empty($col) && file_exists($image_path)){
			return $thumb.$this->$col;
		}
        $image_path = $this->file_dir.$this->$col;
        if(file_exists($image_path)){
            return $this->$col;
        }
        return null;
    }

    /**
     * Visszaadja egy kép  elérését
     * @param string $col annak a kép oszlopnak a neve amit meg akarunk jeleníteni
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    public function getImageUrl($col){
        $image_path = $this->file_dir.$this->$col;

        if(!empty($col) && file_exists($image_path)){
            return url($image_path);
        }
        return null;
    }

}
