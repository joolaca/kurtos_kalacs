<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Traits\Thumbnail;
use App\Model\Lang;
use App\Model\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Fields;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\Flash;

class ThumbnailController extends BaseCrudController
{
    function __construct() {
        $row = 0;

        $this->crud_data = [
            'index_title' => 'Képméretek',
            'index_subtitle' => '',
            'create_title' => 'Képméretek felvétele',
            'create_subtitle' => '',
            'edit_title' => 'Képméretek szerkesztése',
            'edit_subtitle' => '',
            'controller_path' => 'App\Http\Controllers\CRUD\ThumbnailController',
            'js_path' => '',  // egyedi js-t behúzza
            'js_blade_path' => '',// egyedi blade js-t behúzza
            'model_class'   => '\\App\\Model\\ThumbnailSize',
            'url' => 'thumbnail',
            'base_order_by' => ['title', 'asc'],
            'table_crud_btn' => [ // <td> eseménygombok
                'edit' , 'delete',
            ],
            //kereső mezők
            'search' => [
                'all_text_search' => [ //általános kereső mező
                    'label' => trans('global.text_search'),
                    'type' => 'text',//kötelező
                    //'search_in' => ['user_name'] //ha nincs kitöltve az összes text tipusú mezőben keres
                ],
            ],
            'panels'=>[
                (new Fields\Panel('maindata'))
                    ->addRow(
                        (new Fields\Row($row++))
                            ->addField(
                                (new Fields\IntegerField('id'))
                                    ->setLabel('# id')
                            )
                    )
                    ->addRow(
                        (new Fields\Row($row++))
                            ->addField(
                                (new Fields\TextField('title'))
                                    ->setLabel('Neve')
                                    ->setAttributes([
                                        'class' => 'form-control',
                                        'required' => TRUE
                                    ])
                            )
                    )
                    ->addRow(
                        (new Fields\Row($row++))
                            ->addField(
                                (new Fields\TextField('prefix'))
                                    ->setLabel('Prefix')
                                    ->setAttributes([
                                        'class' => 'form-control',
                                        'required' => TRUE
                                    ])
                            )
                    )
                    ->addRow(
                        (new Fields\Row($row++))
                            ->addField(
                                (new Fields\TextField('width'))
                                    ->setLabel('Szélesség')
                                    ->setAttributes([
                                        'class' => 'form-control',
                                        'required' => TRUE
                                    ])
                            )
                    )
                    ->addRow(
                        (new Fields\Row($row++))
                            ->addField(
                                (new Fields\TextField('height'))
                                    ->setLabel('Magasság')
                                    ->setAttributes([
                                        'class' => 'form-control',
                                        'required' => TRUE
                                    ])
                            )
                    )
                    ->addRow(
                        (new Fields\Row($row++))
                            ->addField(
                                (new Fields\TextField('description'))
                                    ->setLabel('Leírás')
                                    ->setAttributes([
                                        'class' => 'form-control',
                                        'required' => TRUE
                                    ])
                            )
                    )

            ],
        ];
        $this->setAllFields();
    }

    public function show($id){
        $menus = Menu::where('category_id', $id)->get();
        return view('admin/crud/menu/menu_category_show', compact('menus'));
    }


    public function setupLangField($field, $item = null){
        $options = Lang::pluck('lang' , 'lang');
        $field->setOptions($options->toArray());
        return;
    }



    public function cropImage($id,$field,$encypted_model_name){

        $modelname = decrypt($encypted_model_name);

        $model = new $modelname;
        $item = $model->find($id);
        $path = $item->file_dir.$item->$field;

        return view('admin/crud/crop' , compact('item' , 'path' , 'field'));

    }

    public function crop(Request $request){

        $size = Thumbnail::getThumbnailSizeUsePrefix($request->prefix);

        $img = Image::make(public_path($request->path));
        $img->crop((integer)$request->w, (integer)$request->h, (integer)$request->x1, (integer)$request->y1);
        $img = Thumbnail::makeResize($img,$size);
        $prefix_path = Thumbnail::getPrefixFilePath($request->path,$request->prefix);
        $img->save(public_path($prefix_path));
        Flash::success('Sikeres módosítás');


        return redirect()->back();
    }

    public function generateThumbnailSizes(Request $request){
        $slide = new Slide();
        $slide->generateThumbnailUsePath($request->path);
        Flash::success('Fájgenerálás megtörtént');
        return redirect()->back();
    }

    public function cropModalView($id,$field,$prefix,$encypted_model_name){

        $modelname = decrypt($encypted_model_name);

        $model = new $modelname;
        $item = $model->find($id);
        $path = $item->file_dir.$item->$field;
        $size = Thumbnail::getThumbnailSizeUsePrefix($prefix);
        $route = url('/admin/make_crop/'.$encypted_model_name);

        return view('admin/crud/crop_modal' , compact('path' , 'item' , 'size', 'route'));

    }


}
