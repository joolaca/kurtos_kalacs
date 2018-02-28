<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\CRUD\BaseCrudController;
use App\Http\Requests\ContentRequest;
use App\Model\Content;
use App\Model\Lang;
use Illuminate\Http\Request;
use App\Http\Fields;

class ContentController extends BaseCrudController
{

    function __construct() {
        $row = 0;

        $this->crud_data = [
            'index_title' => 'Tartalom',
            'index_subtitle' => '',
            'create_title' => 'Tartalom felvétele',
            'create_subtitle' => '',
            'edit_title' => 'Tartalom szerkesztése',
            'edit_subtitle' => '',
            'controller_path' => 'App\Http\Controllers\CRUD\ContentController',
            'js_path' => '',  // egyedi js-t behúzza
            'js_blade_path' => '',// egyedi blade js-t behúzza
            'model_class'   => '\\App\\Model\\Content',
            'url' => 'content',
            'base_order_by' => ['name', 'asc'],
            'table_crud_btn' => [ // <td> eseménygombok
                'edit' , 'delete',
            ],
            //kereső mezők
            'search' => [
                'all_text_search' => [ //általános kereső mező
                    'label' => "Szókereső",
                    'type' => 'text',//kötelező
                    'search_in' => ['content', 'lead', 'title'] //ha nincs kitöltve az összes text tipusú mezőben keres
                ],
                'lang' => [ //általános kereső mező
                    'label' => 'Nyelv',
                    'type' => 'select',//kötelező
                    'empty' => 'Minden nyelv',
                    'options' => Lang::all()->pluck('lang', 'lang'),
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
                        (new Fields\Row('body'))
                            ->addField(
                                (new Fields\TinyMceField('content'))
                                    ->setLabel("tartalom")
                                    ->setValidationRules('required')
                                    ->setAttributes([
                                        'class' => 'tinymce',
                                        'rows' => '20'
                                    ])
                            )
                    )

            ],
        ];
        $this->setAllFields();
    }

    public function setupLangField($field, $item = null){
        $options = Lang::pluck('lang' , 'lang');
        $field->setOptions($options->toArray());
        return;
    }

    /**
     * Frontent megjelenítő
     * @param $request
     * @param $menu_contents  Menü rendeléskor megadott egyébb adatok
     */
    public function renderFrontendHtml($request,$menu_content){

        $model = new $this->crud_data['model_class'];
        $content = $model->find($menu_content->related_id);
        return $content->content;

    }



}
