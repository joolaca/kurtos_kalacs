<?php

namespace App\Http\Controllers\CRUD;

use App\Model\Lang;
use App\Model\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Fields;

class MenuCategoryController extends BaseCrudController
{
    function __construct() {
        $row = 0;

        $this->crud_data = [
            'index_title' => 'Menü kategória',
            'index_subtitle' => '',
            'create_title' => 'Menü kategória felvétele',
            'create_subtitle' => '',
            'edit_title' => 'Menü kategória szerkesztése',
            'edit_subtitle' => '',
            'controller_path' => 'App\Http\Controllers\CRUD\MenuCategoryController',
            'js_path' => '',  // egyedi js-t behúzza
            'js_blade_path' => '',// egyedi blade js-t behúzza
            'model_class'   => '\\App\\Model\\MenuCategory',
            'url' => 'menu_category',
            'base_order_by' => ['title', 'asc'],
            'table_crud_btn' => [ // <td> eseménygombok
                'edit' , 'delete',
                'menu_items' => [
                    'type'   => 'link_with_id',
                    'label'  => 'Menpontok',
                    'method' => '',// végrehajtó függvény
                    'class'  => 'btn-primary',
                    'controller'  => 'admin/menu', // ha van ide küldi a linket
                ],
            ],
            //kereső mezők
            'search' => [

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
                                (new Fields\StaticSelectField('lang'))
                                    ->setLabel('Nyelv')
                                    ->setValidationRules('required')
                                    ->setSetupFunction('setupLangField')
                                    ->setAttributes([
                                        'required' => TRUE
                                    ])
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

}
