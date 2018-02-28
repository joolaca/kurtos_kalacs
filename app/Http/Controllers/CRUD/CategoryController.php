<?php

namespace App\Http\Controllers\CRUD;

use App\Model\Lang;
use App\Model\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Fields;
use Illuminate\Support\Facades\URL;


class CategoryController extends BaseCrudController
{

    public $category_type = '';

    function __construct() {
        $row = 0;

        $this->crud_data = [
            'index_title' => 'Kategoria',
            'index_subtitle' => '',
            'create_title' => 'Kategoria felvétele',
            'create_subtitle' => '',
            'edit_title' => 'Kategoria szerkesztése',
            'edit_subtitle' => '',
            'controller_path' => 'App\Http\Controllers\CRUD\CategoryController',
            'js_path' => '',  // egyedi js-t behúzza
            'js_blade_path' => '',// egyedi blade js-t behúzza
            'model_class'   => '\\App\\Model\\Category',
            'url' => 'categories',
            'base_order_by' => ['title', 'asc'],
            'hide_create_button' => true,
            'render_index_button' => 'renderCategoryIndexButton',
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
                                (new Fields\HiddenField('type'))
                                ->setSetupFunction('setupTypeHiddenField')
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

    /**
     * Az indexben lehet a querynek + paramétereket adni, ha a kontrolerben overridolod ezt a függvényt
     * @param $query
     * @return mixed
     */
    public function indexCustomConditions($model){
        $model = $model->where('type', $this->category_type);
        return $model;
    }

    public static function renderCategoryIndexButton(){
        $url_array = explode('/',URL::current());
        $type = end($url_array);

        $out = '<button type="button" class="new_content_type_view btn btn-success pull-right "
                                data-href="'.url('/admin/categories/'.$type.'/create').'">

                        </button>';

        $out = '<a class="btn btn-success pull-right"
                href="'.url('/admin/categories/'.$type.'/create').'">
                '.trans('global.add_new').
            '</a>';
        return $out;

    }

    public function create_category($type){
        $this->category_type = $type;
        $view = parent::create();
        return $view;
    }

    public function store(Request $request){
        parent::store($request);
        return redirect('/admin/'.$this->crud_data['url'].'/'.$request->type);
    }


    public function setupTypeHiddenField($field, $item = null){
        if(is_null($item)){
            $field->setDefault($this->category_type);
        }  else{
            $field->setDefault($item->type);
        }

        return;
    }

}
