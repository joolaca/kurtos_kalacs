<?php

namespace App\Http\Controllers\CRUD;

use App\Helper\StrHelper;
use App\Model\Category;
use App\Model\Gallery;
use App\Model\Lang;
use App\Model\Menu;
use App\Model\Slide;
use App\Model\SlideContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Fields;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class SlideController extends BaseCrudController
{
    function __construct() {
        $row = 0;

        $this->crud_data = [
            'index_title' => 'Kép',
            'index_subtitle' => '',
            'create_title' => 'Kép felvétele',
            'create_subtitle' => '',
            'edit_title' => 'Kép szerkesztése',
            'edit_subtitle' => '',
            'controller_path' => 'App\Http\Controllers\CRUD\SlideController',
            'js_path' => '',  // egyedi js-t behúzza
            'js_blade_path' => '',// egyedi blade js-t behúzza
            'model_class'   => '\\App\\Model\\Slide',
            'url' => 'slides',
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
                                (new Fields\ImageField('image'))
                                    ->setLabel('Kép')
                                    ->setAttributes([
                                        'required' => true,
                                    ])
                            )
                    )
                    ->addRow(
                        (new Fields\Row($row++))
                            ->addField(
                                (new Fields\SelectField('category_id'))
                                    ->setRelationMethod('category')
                                    //                                ->setValidationRules('required')
                                    ->setSetupFunction('setupCategoryField')
                                    ->setEdit(['label' => 'Kategoria' , 'col' => 'category_id'])
                                    ->setIndex([
                                        ['label' => 'Kategoria' , 'col' => 'title'],
                                    ])
                                    ->setAttributes([
                                        'required' => true,
                                        'class' => 'select_'
                                    ])
                            )
                    )


            ],

        ];


        foreach (Lang::all() as $lang) {
            $newPanel = (new Fields\Panel('presubdata'))
                ->setTitle($lang->title)
                ->addRow(
                    (new Fields\Row($row++))
                        ->addField(
                            (new Fields\TextField('title_'.$lang->lang))
                                ->setLabel('Neve')
                                ->setAttributes([ 'class' => 'form-control', ])
                                ->setSetupFunction('setupTitle')

                        )
                )
                ->addRow(
                    (new Fields\Row($row++))
                        ->addField(
                            (new Fields\TinyMceField('content_'.$lang->lang))
                                ->setLabel('Tartalom')
                                ->setSetupFunction('setupContent')
                                ->setAttributes([ 'class' => 'tinymce', 'rows' => '10', ])
                        )
                );

            $this->crud_data['panels'][] = $newPanel;
        }




        $this->setAllFields();
    }


    public function setupCategoryField($field, $item = null){
        $groups = Category::where('type', 'slide')->pluck('title', 'id');
        $field->setOptions($groups->toArray());
    }
    public function setupGalleryField($field, $item = null){
        $groups = Gallery::all()->pluck('title', 'id');
        $field->setOptions($groups->toArray());
    }

    //Editnél beállítja a title -t
    public function setupTitle($field, $item = null){
        if(is_null($item)){ return; }
        $name = explode('_',$field->getName());
        $lang = end($name);
        $content = $item->titleLang($lang);
        $field->setDefault($content);

    }

    //Editnél beállítja a content -t
    public function setupContent($field, $item = null){
        if(is_null($item)){ return; }
        $name = explode('_',$field->getName());
        $lang = end($name);

        $content = $item->contentLang($lang);
        $field->setDefault($content);
    }



    /**
     * Tömeges képfeltöltés megjelenítő
     */
    public function multipleUploadView(){
        
        $row = 1;
        $this->crud_data['create_title'] = 'Tömeges feltöltés';
        $this->crud_data['url'] = $this->crud_data['url'].'/multiple_upload';
        $this->crud_data['panels'] = [
            (new Fields\Panel('maindata'))
                ->addRow(
                    (new Fields\Row($row++))
                        ->addField(
                            (new Fields\FileMultipleField('file'))
                                ->setLabel('Fájlok')
                                ->setAttributes([
                                    'required' => true
                                ])
                        )
                )
                ->addRow(
                    (new Fields\Row($row++))
                        ->addField(
                            (new Fields\SelectField('category_id'))
                                ->setRelationMethod('category')
                                //                                ->setValidationRules('required')
                                ->setSetupFunction('setupCategoryField')
                                ->setEdit(['label' => 'Kategoria' , 'col' => 'category_id'])
                                ->setIndex([
                                    ['label' => 'Kategoria' , 'col' => 'title'],
                                ])
                                ->setAttributes([
                                    'required' => true,
                                    'class' => 'select_'
                                ])
                        )
                )
                ->addRow(
                    (new Fields\Row($row++))
                        ->addField(
                            (new Fields\SelectField('gallery_id'))
                                ->setRelationMethod('gallery')
                                //                                ->setValidationRules('required')
                                ->setSetupFunction('setupGalleryField')
                                ->setEdit(['label' => 'Galléria' , 'col' => 'gallery'])
                                ->setIndex([
                                    ['label' => 'Gallery' , 'col' => 'title'],
                                ])
                                ->setAttributes([
                                    'class' => 'select_'
                                ])
                        )
                ),

        ];
        $this->setAllFields();

        return parent::create();

    }


    /**
     * Elvégzi a tömeges feltöltést
     * @param Request $request
     */
    public function multipleUpload(Request $request){

        $imageRules = ['image' => 'image|max:30000'];
        $bad_file = '';
        $slides = [];
        foreach ($request->file as $file) {

            //Validáció
            $image = ['image' => $file];
            $imageValidator = Validator::make($image, $imageRules);


            $file_name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $filename = StrHelper::slug_file_name($file_name, $ext,'_');


            if ($imageValidator->fails()) {
                $bad_file .= $filename.',';
                continue;
            }

            $item = new $this->crud_data['model_class']();
            //fájl neve lesz kezdetben a cím
            $request->offsetSet('title_hu', explode('.',$file->getClientOriginalName())[0]);

            $item = $item->create($request->all());
            $file_path = $this->generateFilePath($this->crud_data['url'],$item->id);

            $item->file_dir = $file_path;
            $item->image = $filename;
            $item->save();

            if($request->gallery_id != ''){
                $item->galleries()->attach($request->gallery_id);
            }


            $upload_success = $file->move($file_path, $filename);
            $slides[] = $item;
//            $item->generateThumbnailUsePath(public_path($file_path.$filename));
        }

        if($bad_file == ''){
            Flash::success('Sikeres feltöltés');

        }else{
            Flash::error('Rossz fájlok : '.$bad_file);
        }

        return view('admin/page/slides/multiple_upload_thumbnail_generate',compact('slides'));


//        return redirect($this->crud_data['url']);
    }


    public function generateSlideThumbnail(Request $request){
        $slide = Slide::find($request->id);
        $slide->generateThumbnail();
        return response()->json($slide);
    }


    /**
     *
     * Kép(ek) törlése
     *
     * szükséges paraméterek:
     *  - model (post): model elérése
     *  - col_name (get): adatbázis mező neve (pl: image)
     *  - row_id (get): adatbázis sor id-ja
     *
     * Ha a model thumnailable akkor a thumnail képeket is töröljük
     *
     * JSON visszatérés
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function deleteImage(Request $request){

        $result = new \stdClass();
        $result->error = false;
        $result->html = null;

        try{

            //GET PARAMÉTEREK
            $row_id = $request->row_id;
            $model_path = $request->model;
            $col_name = $request->col_name;

            //model példányosítása
            $model = new $model_path;
            //törölni kívánt elem sorának lekérdezése
            $item = $model->findOrFail($row_id);

            //kép elérése
            $path = $item->file_dir.$item->$col_name;

            //thumbnail képek törlése, ha van thumnail
            if(method_exists($model_path, 'generateThumbnail')){
//                $item->deleteThumbnail($path);
            }

            //kép mező kinullázása & mentés
            $item->$col_name = null;
//            $item->save();

            //kép törlése
//            unlink($path);

            //success üzenet
            $result->message = trans('global.delete_image_success');
            return response()->json($result);

        }catch (\Exception $e){

            //hibakezelés
            $result->error = true;
            $result->message = trans('global.delete_image_error');
            return response()->json($result, 400);

        }
    }


    public function iframeSelectSlide(Request $request){
        return view('admin/select_slide');
    }

    /** Modal ablakba a választható képeket mutatja kategóriára szűrve
     * @param Request $request
     * @return html
     */
    public function getModalSlides(Request $request){
        if(empty($request->category_id)){
            session(['slide_category_id_modal' => null]);
            $slides = Slide::all();
        }else{
            session(['slide_category_id_modal' => $request->category_id]);
            $slides = Slide::where('category_id', $request->category_id)->get();
        }

        $out = '';
        foreach ($slides as $slide) {
            $out.= view('admin/modal/select_slide_modal_element', compact('slide'))->render();
        }
        return $out;
    }

    

    public function update(Request $request, $id){
        $out = parent::update($request, $id);

        // Nyelvedített conten meg title külön mentjük
        foreach (Lang::all() as $lang) {
            $slide_content = SlideContent
                ::where('slide_id', $id)
                ->where('lang', $lang->lang)
                ->first();
            if(empty($slide_content)){
                $slide_content = new SlideContent();
                $slide_content->slide_id = $id;
                $slide_content->lang = $lang->lang;
            }

            $slide_content->content = $request->{'content_'.$lang->lang};
            $slide_content->title = $request->{'title_'.$lang->lang};
            $slide_content->save();
        }
        return $out;
    }

}
