<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\PageController;
use App\Http\Controllers\SystemController;
use App\Model\Content;
use App\Model\ContentMenu;
use App\Model\Gallery;
use App\Model\GoogleMap;
use App\Model\Menu;
use App\Model\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Fields;
use Illuminate\Support\Facades\Log;

class MenuController extends BaseCrudController
{
    public $menu_category; // pl index megjelenítésnél erre is szűrünk
    protected $items_from = []; //editnél ezekből a modellekből lehet választani amit a menühöz rendelsz
    protected $items_to = []; // Ezek már rendelve vannak a menühöz
    function __construct() {
        $row = 0;

        $this->crud_data = [
            'index_title' => 'Menü',
            'index_subtitle' => '',
            'create_title' => 'Menü kategória felvétele',
            'create_subtitle' => '',
            'edit_title' => 'Menü kategória szerkesztése',
            'edit_subtitle' => '',
            'controller_path' => 'App\Http\Controllers\CRUD\MenuController',
            'js_path' => '/assets/js/admin/edit_menu_item.js',  // egyedi js-t behúzza
            'js_blade_path' => '',// egyedi blade js-t behúzza
            'model_class'   => '\\App\\Model\\Menu',
            'url' => 'menu',
            'base_order_by' => ['title', 'asc'],
            'hide_create_button' => true,
            'render_index_button' => 'renderCreateButton',
            'table_crud_btn' => [ // <td> eseménygombok
                'edit' , 'delete',
                [ 'type' => 'render', 'method' => 'renderOtherMenuButtons', ]
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
                                    ->setLabel('Cím')
                                    ->setValidationRules('required')
//                                    ->setIcon('user')
                                    ->setAttributes([
                                        'placeholder' => 'Cím',
                                        'class' => 'form-control',
                                        'required' => TRUE
                                    ])
                            )
                    )
                    ->addRow(
                        (new Fields\Row($row++))
                            ->addField(
                                (new Fields\TextField('slug'))
                                    ->setLabel('Url')
                                    ->setAttributes([
                                        'class' => 'form-control',
                                    ])
                            )
                    )
                    ->addRow(
                        (new Fields\Row($row++))
                            ->addField(
                                (new Fields\HiddenField('category_id'))
                                    ->setSetupFunction('setCategoryId')
                            )
                            ->addField(
                                (new Fields\HiddenField('lang'))
                                    ->setSetupFunction('setLang')
                            )
                    )

            ],
        ];
        $this->setAllFields();
    }


    /** Ez a menü index csak így gyszerűbb
     * @param Request $request
     * @param $menu_category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $menu_category_id){
        $menus =Menu::where('category_id',$menu_category_id)->
                where('sequence', 1)
                ->get();
        if(count($menus) > 1){
            $i=count($menus);
            foreach ($menus as $menu) {
                $menu->sequence = $i;
                $menu->save();
                $i--;
            }
        }
        $this->menu_category = MenuCategory::find($menu_category_id);
        session(['manu_lang' => $this->menu_category->lang]);
        return  $this->index($request);
    }

    /**Sorrend állítás indexnél BaseCrudController felülírása
     * @param $model
     * @return mixed
     */
    public function OrderItem($model){
        return $model->orderBy('sequence', 'DESC');

    }

    /**Menü index rászűr a kategóriára
     * @param $model
     * @return mixed
     */
    public function indexCustomConditions($model){
        $model = $model->where('category_id', $this->menu_category->id);
        return $model;
    }


    public function edit($id){
        $view = parent::edit($id);
        $portlets = $this->renderPortlet($id);
        $view->with('portlets' , $portlets);

        return $view;
    }

    /** Editnél elkészíti a tartalom hozzárendelő részt
     * @param $menu_id
     * @return array
     * @throws \Exception
     * @throws \Throwable
     */
    public function renderPortlet($menu_id){
        $this->items_from = new \Illuminate\Database\Eloquent\Collection;
        $this->items_to = new \Illuminate\Database\Eloquent\Collection;

        $this->setContentItemsFromTo($menu_id);
        $this->setGalleryItemsFromTo($menu_id);
        $this->setGoogleMapItemsFromTo($menu_id);

        $items_from = $this->items_from;
        $items_to = $this->items_to;
        return [view('admin/crud/menu/edit/attach_content_porlet', compact('items_from', 'items_to', 'menu_id'))->render()];

    }

    /** Hozzá rendel egy menüponthoz egy contentet
     * @param Request $request
     * @return string
     */
    public function attachContent(Request $request){

        ContentMenu::create([
            'menu_id' => $request->menu_id,
            'related_id' => $request->related_id,
            'content_controller' => $request->content_controller,
            'type' => $request->type,
        ]);
//        return $request->all();
        return redirect()->back();
    }

    /** Hozzárendelést bont
     * @param Request $request
     * @return array
     */
    public function detachContent(Request $request){
        $content_menu = ContentMenu
            ::where('related_id', $request->related_id)
            ->where('menu_id', $request->menu_id)
            ->where('content_controller', $request->content_controller)
            ->first();

        if(!empty($content_menu)){
            $content_menu->delete();
        }

//        return $request->all();
        return redirect()->back();
    }
    /**
     * Szerkesztésnél megkeresi azokat az elemeket amik hozzá lehet rendelni a menüponthoz
     */
    public function setContentItemsFromTo($id = null){
        //Szoveges tartalmak
        $contents_to =ContentMenu::where('content_controller', 'Like', '%ContentController%');
        if(!is_null($id)){
            $contents_to = $contents_to->where('menu_id', $id);
        }
        $contents_to_id = $contents_to->get()->pluck('related_id');


        $contents_form = Content::where('lang', session('manu_lang'))
            ->whereNotIn('id', $contents_to_id)
            ->get();
        foreach($contents_form as $content){
            $content->content_controller = '\\App\\Http\\Controllers\\CRUD\\ContentController';
            $this->items_from = $this->items_from->push($content);
        }
        $contents_to = Content::where('lang', session('manu_lang'))
            ->whereIn('id', $contents_to_id)
            ->get();
        foreach($contents_to as $content){
            $content->content_controller = '\\App\\Http\\Controllers\\CRUD\\ContentController';
            $this->items_to = $this->items_to->push($content);
        }
    }

    /** HMenühöz rendelhető galériák
     * @param null $id
     */
    public function setGalleryItemsFromTo($id = null){
        $contents_to =ContentMenu::where('content_controller', 'Like', '%GalleryController%');

        if(!is_null($id)){
            $contents_to = $contents_to->where('menu_id', $id);
        }
        $contents_to_id = $contents_to->get()->pluck('related_id');

        $contents_form = Gallery
            ::whereNotIn('id', $contents_to_id)
            ->get();
        foreach($contents_form as $content){
            $content->content_controller = '\\App\\Http\\Controllers\\CRUD\\GalleryController';
            $this->items_from = $this->items_from->push($content);
        }
        $contents_to = Gallery
            ::whereIn('id', $contents_to_id)
            ->get();
        foreach($contents_to as $content){
            $content->content_controller = '\\App\\Http\\Controllers\\CRUD\\GalleryController';
            $this->items_to = $this->items_to->push($content);
        }
    }

    /**
     * Menühöz elkészíti a google map modul kiválasztót
     */
    public function setGoogleMapItemsFromTo($id = null){

        $attach_menu =ContentMenu::where('content_controller', 'Like', '%GoogleMapController%')->where('menu_id', $id)->count();

        $content = new GoogleMap();
        $content->slug = 'GoogleMapRolunk';
        $content->title = 'GoogleMapRolunk';
        $content->id = 1;

        if($attach_menu == 0){
            $content->content_controller = '\\App\\Http\\Controllers\\CRUD\\GoogleMapController';
            $this->items_from = $this->items_from->push($content);
        }else{
            $content->content_controller = '\\App\\Http\\Controllers\\CRUD\\GoogleMapController';
            $this->items_to = $this->items_to->push($content);
        }

    }

    public function createMenuItem($category_id){
        $this->menu_category = MenuCategory::find($category_id);
        return parent::create();
    }

    public function setCategoryId($field, $item = null){
        if($item == null){ // createMenuItem kell
            $field->setDefault($this->menu_category->id);
        }else{
            $field->setDefault($item->category_id);
        }
    }

    public function setLang($field, $item = null){
        if($item == null){ // createMenuItem kell
            $field->setDefault($this->menu_category->lang);
        }
    }


    /** admin/menu/1 url en megjelenő "Új menüpont gomb"
     * @return string
     */
    public static function renderCreateButton(){
        $fullURL = \Request::fullUrl();
        $explode_url = explode('/', $fullURL);
        return '<a class="btn btn-success pull-right" href="'.url('/admin/menu/create/'.end($explode_url)).'"> Új menüpont </a>';
    }

    public function store(Request $request){
        parent::store($request);
        return redirect('admin/'.$this->crud_data['url'].'/'.$request->category_id);
    }

    public function destroy($id){
        $content_menus = ContentMenu
            ::where('menu_id', $id)
            ->get();
        foreach ($content_menus as $content_menu) {
            $content_menu->delete();
        }



        $model = new $this->crud_data['model_class'];
        $item = $model::find($id);
        parent::destroy($id);
        return redirect('admin/'.$this->crud_data['url'].'/'.$item->category_id);
    }

    public function update(Request $request, $id){
        parent::update($request, $id);
        return redirect('admin/'.$this->crud_data['url'].'/'.$request->category_id);
    }


    /** Frontenden előállítja a menüt
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function renderFrontendMenu(){
        $full_url = \Request::fullUrl();
        $menus = Menu::where('lang', SystemController::getLang())
            ->orderBy('sequence', 'DESC')
            ->get();

        return view('menu', compact('menus', 'full_url'));
    }


    /** Ajax hívás megváltoztatja a menü sorrendjét
     * @param Request $request
     */
    public function changeMenuSequence(Request $request){

        $selected_menu = Menu::find($request->id);
        $change_menus = Menu
            ::where('lang', $selected_menu->lang)
            ->where('id', '!=',$selected_menu->id )
            ->orderBy('sequence')
            ->get();



        if($request->action == "lift_up"){
            $new_sequence = $selected_menu->sequence +1;

        }else{
            $new_sequence = $selected_menu->sequence -1;
        }

        if($request->sequence == 0 || $new_sequence == count($change_menus)+1){
            return $request->all();
        }

        $i=1;
        foreach($change_menus as $menu){
            if($i == $new_sequence){
                $selected_menu->sequence = $i;
                $selected_menu->save();
                $i++;
            }
            $menu->sequence = $i;
            $menu->save();
            $i++;
        }
        return $request->all();

//        return "";

    }

}
