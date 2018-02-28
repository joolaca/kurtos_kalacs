<?php

namespace App\Http\Controllers\CRUD;

use App\Model\Category;
use App\Model\Gallery;
use App\Model\Lang;
use App\Model\Menu;
use App\Model\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Fields;

class GalleryController extends BaseCrudController
{

    public $category_type = '';

    function __construct() {
        $row = 0;

        $this->crud_data = [
            'index_title' => 'Galéria',
            'index_subtitle' => '',
            'create_title' => 'Galéria felvétele',
            'create_subtitle' => '',
            'edit_title' => 'Galéria szerkesztése',
            'edit_subtitle' => '',
            'controller_path' => 'App\Http\Controllers\CRUD\GalleryController',
            'js_path' => '',  // egyedi js-t behúzza
            'js_blade_path' => '',// egyedi blade js-t behúzza
            'model_class'   => '\\App\\Model\\Gallery',
            'url' => 'galleries',
            'base_order_by' => ['title', 'asc'],
            'table_crud_btn' => [ // <td> eseménygombok
                'edit' , 'delete',
                'menu_items' => [
                    'type'   => 'link_with_id',
                    'label'  => 'Képei',
                    'method' => '',// végrehajtó függvény
                    'class'  => 'btn-primary',
                    'controller'  => 'admin/gallery_slide', // ha van ide küldi a linket
                ],
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

            ],
        ];
        $this->setAllFields();
    }

    public function list_category(Request $request, $type){

        $this->category_type = $type;
        return  $this->index($request);

    }


    /** Megjelenítő galériához képet lehet hozzárendelni vagy elvenni
     * @param Request $request
     * @param $gallery_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function gallerySlide(Request $request, $gallery_id){
        $my_slide = Gallery::find($gallery_id);
        $my_slide = $my_slide->slides->pluck('id');

        $categories = Category::where('type','slide')->pluck('title', 'id');

        $model = new Slide();
        if(isset($request->category_id)){
            $model = $model->where('category_id', $request->category_id);
        }
        $slides = $model->paginate(50);
        $slides->appends($request->all());

        return view('admin/crud/gallerySlide/choose_slide',
            compact(
                'gallery_id', 'slides', 'my_slide', 'request', 'categories'
            ));
    }


    /**hozzáad vagy elvesz egy képet egy galériához
     * @param Request $request
     */
    public function addSlide(Request $request){
        $gallery = Gallery::find($request->gallery_id);
        $action = $request->action;
        $gallery->slides()->$action($request->slide_id);
    }


    /**
     * Frontent megjelenítő
     * @param $request
     * @param $menu_contents  Menü rendeléskor megadott egyébb adatok
     */
    public function renderFrontendHtml($request,$menu_content){

        $model = new $this->crud_data['model_class'];
        $gallery = $model->find($menu_content->related_id);
        $gallery->gallery_id = $gallery->id;

        switch ($menu_content->type) {
            case 'bootstrap_gallery':
                return view('page/gallery/bootstrap_gallery')
                    ->with([ 'item' => $gallery ])
                    ->render();  //
                break;
            case 'slider_full_with':
                return view('page/gallery/slider_full_with')
                    ->with([ 'item' => $gallery ])
                    ->render();
                break;
            default:
                break;
        }

    }

}

