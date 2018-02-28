<?php

namespace App\Http\Controllers\CRUD;

use App\EmailQueue;
use App\Helper\CsvHelper;
use App\Helper\OrderHelper;
use App\Helper\SearchHelper;

use App\Http\Controllers\SystemController;

//use Conner\Tagging\Model\Tag;

use App\Http\Traits\Thumbnail;
use App\Model\Company;
use App\Model\ContentPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Helper\StrHelper;
use Intervention\Image\ImageManager;
use Laracasts\Flash\Flash;
use Intervention\Image\Facades\Image;
use App\Http\Fields;


class BaseCrudController extends Controller
{
    use Thumbnail;

    const MAGIC_NUMBER = 666;

    protected  $view_path = 'admin/crud/';
    public $item_id = null; // szerkesztésnél
	//

	public $crud_data = [];

	protected $_fields = [];
	protected $index_fields = [];
	protected $isOrderable = false; //Drg & drop sorrendezhető lista nézetet kell-e renderelni


    /**
     * Rekord szerkesztése
     */
    public function edit($id){

        $this->item_id = $id;


        $model = new $this->crud_data['model_class'];
        $item = $model->findOrFail($id);

        $this->crud_data['item'] = $item;

        $this->callSetupFunction($item);


        return view($this->view_path.'edit', $this->crud_data);

    }


    /**
     * Új rekord létrehozása
     */
    public function create(){
        $this->callSetupFunction();
        return view($this->view_path.'create', $this->crud_data);
    }


    /**
     * Listanézet
     */
    public function index(Request $request)
    {

		$this->callSetupFunction();
        $model = new $this->crud_data['model_class'];
        $model = $this->FileterSearchValue($model,$this->crud_data, $request, $this->index_fields);
        $model = $this->indexCustomConditions($model);
        $model = $this->OrderItem($model);


        $perPage = isset($this->crud_data['paginate_per_page'])?$this->crud_data['paginate_per_page']:env('PAGINATOR_PRE_PAGE',50);
        $items = $model->paginate($perPage);

        $searchDatas = $this->setSearchData($request,$this->crud_data, $this->index_fields);

        $search = null;
        if(count($searchDatas) > 0){//ha van(nak) keresőhöz beállítva mező(k)
            $search['view'] = $searchDatas;
            $search['value']= $request->all();
        }

        return view($this->view_path.'index', [
			'is_orderable' => $this->isOrderable,
            'items'  => $items,
            'search' => $search,
			'index_fields' => $this->getIndexFields(),
            'crud_data' => $this->crud_data,
//            'fields' => $this->crud_data,
			'sort' => ((!empty($request->sort)) ? $request->sort : null),
			'direction' => ((!empty($request->direction)) ? $request->direction : null),

        ]);
    }



    public function store(Request $request){


        $modified_request= $this->changeInputData($request);

		$rules = $this->getValidationRules();
        if(!is_null($rules)){
            $this->validate($modified_request, $rules);
        }

        $model = new $this->crud_data['model_class'];

        $id = $model->create($modified_request->all())->id;

        $item = $model->find($id);

        $this->syncMayToMay($item, $modified_request);
        $this->fileUpload($item, $request);
        $this->setTags($item, $request);


        Flash::success('Sikeres mentés');
        $url_prefix = isset($this->crud_data['url_prefix'])?$this->crud_data['url_prefix']:'';
        if (session()->exists('search_value')){
            return redirect('/admin/'.$url_prefix.$this->crud_data['url']. '?' . http_build_query(session('search_value')));
        }else{
            return redirect('/admin/'.$url_prefix.$this->crud_data['url']);
        }

    }

    public function update(Request $request, $id){

        $modified_request= $this->changeInputData($request);

        if(!is_null($this->getValidationRules())){
            $rules = $this->getValidationRules();
            unset($rules['password']); //updatenél nem kötelező megadni
            $this->validate($modified_request, $rules);
        }

        $model = new $this->crud_data['model_class'];
        $item = $model->findOrFail($id);

        $item->fill($modified_request->all())->update();


        $this->syncMayToMay($item, $modified_request);
        $this->fileUpload($item, $request);
        $this->setTags($item, $request);


        $this->existingPictureThumbnailGeneration($item,$request);

        Flash::success('Sikeres módosítás');

		//Ha egyei helyre kell redirect-elni mentés után a formba be kell rakni egy redirec_to hidden field-et
		if(!empty($modified_request->redirect_to)) {
			$this->crud_data['url'] = $modified_request->redirect_to;
		}


        if (session()->exists('search_value')){
            return redirect('admin/'.$this->crud_data['url']. '?' . http_build_query(session('search_value')));
        }else{
            return redirect('admin/'.$this->crud_data['url']);
        }

    }




    /**
     * Létező képnél legenerálja újra a thumbnail eket
     * @param $item Most szerkesztett elem
     * @param $request
     */
    private function existingPictureThumbnailGeneration($item,$request){
        if(method_exists($this->crud_data['model_class'], 'generateThumbnail')
        ){

            foreach ($this->_fields as $field_key => $field) {
                if(
                    $field->getType() == 'image' &&
                    !is_null($item->$field_key ) && // Adatbázisban szerepel
                    is_null($request->file($field_key)) && // nem most feltöltött kép
                    in_array($field_key, $item->thumbnail_col_name) // modelban be van állítva hogy kell thumbnail
                ){
                    $file_path = $item->{$field->getPathCol()} . $item->$field_key;
                    $item->generateThumbnailUsePath($file_path);
                }

            }
        }
    }

    public function destroy($id)
    {
        // delete
        $model = new $this->crud_data['model_class'];
        $item = $model::find($id);
        $item->delete();

        Flash::success('Sikeres törlés');
        return redirect('/admin/'.$this->crud_data['url']);
    }

    /**
     * Meghívja a setup függvényt azoknál a mezőknél ahol options, vagy default értéket kell beállítani
     * @param null $item editnél a szerkeztendő objektum
     */
    public function callSetupFunction($item = null){
		$arr_setUp = [];

        foreach ($this->_fields as $field) {

            if( $field->getType() == 'tags'){
                //dd($field->getSetupFunction());
            }

            if($field->getSetupFunction() != ''){

                $function = $field->getSetupFunction();

                $this->$function($field,$item);
				$arr_setUp[$field->getName()] = 1;
            }

        }
        foreach ($this->index_fields as $field) {
			if(!empty($arr_setUp[$field->getName()])) {
				continue;
			}
            if( $field->getType() == 'tags'){
                //dd($field->getSetupFunction());
            }

            if($field->getSetupFunction() != ''){

                $function = $field->getSetupFunction();

                $this->$function($field,$item);
            }

        }

        return;
    }


    /**
     * crud data fieds ben meghatározott validálási szabályokat szedi össze
     * pl:   $crud_data['fields']['name']['validation_rules'] = 'required'
     * @return array $rules
     */
    protected function getValidationRules(){
        $out = [];
		if(!empty($this->_fields)) {
			foreach ($this->_fields as $field_key => $field) {
				$validation_rules = $field->getValidationRules();
				if(!empty($validation_rules)) {
					$out[$field_key] = $validation_rules;
				}
			}
		}

        return $out;
    }

    /** Fields ek alapján a bejövő adatok manipulációja
     * @param array $input
     */
    public function changeInputData($request){
        if(!empty($this->_fields)) {
//            dd($this->_fields);
			foreach ($this->_fields as $field) {
				//Azok a field-ek nem érdekesek, amik nem jelennek meg form-on
				if($field->isHideEdit()) {
					continue;
				}

                //ha nem kapunk értéket akkor 0
				if($field->getType() == 'switch' || $field->getType() == 'boolean'
				){
				    $new_value =  (!empty($request->{$field->getName()})) ? true : false;
                    $request->offsetSet($field->getName(), $new_value);
				}

				//Kitöltetlen passwordel nem fogglalkozunk
				if($field->getType() == 'password'){
					if($request->{$field->getName()} == ''){
                        $request->offsetUnset($field->getName());
					}else{
                        $request->offsetSet($field->getName(), Hash::make($request->{$field->getName()}));
					}
				}

                if( $field->getType() == 'tags' && $request->{$field->getName()} == '' ){
                    $request->offsetUnset($field->getName());
                }

                if( $field->getType() == 'select' && $request->{$field->getName()} == '' ){
                    $request->offsetSet($field->getName(), null);
                }

                if( $field->getType() == 'static_select' && $request->{$field->getName()} == '' ){
                    $request->offsetSet($field->getName(), null);
                }

				if($field->getType() == 'hidden'){
					if($request->{$field->getName()} == ''){
                        $request->offsetUnset($field->getName());
					}
				}
				if($field->getType() == 'datetimepicker'){
					if($request->{$field->getName()} == ''){
						$request->request->set($field->getName(), null);
                        //$request->offsetUnset($field->getName());
					}
				}
                if($field->getType() == 'slide' && $request->{$field->getName()} == ''){
                        $request->offsetSet($field->getName(), NULL);
                }
                if($field->getType() == 'icon' && $request->{$field->getName()} == ''){
                    $request->offsetSet($field->getName(), NULL);
                }
			}
		}
        return $request;
    }

    /** A töb több kapcsolatokat létrehozza
     * @param Model $item Az éppen létrehozott elem modelje
     * @param array $input bejövő adatok
     */
    public function syncMayToMay($item, $request){

		if(!empty($this->_fields)) {
			foreach ($this->_fields as $field_key=>$field) {
				//if(!isset($field['type']))continue;

				if($field->getType() == 'select2'
					|| $field->getType() == 'multiple_order'
				){

					if(is_null($request->{$field->getName()})){ //jött tömb
                        $item->$field_key()->sync([]);
					}else{
                        //Sorrend miatt mindíg kinullázzuk
                        $item->$field_key()->sync([]);
                        $item->$field_key()->sync($request->{$field->getName()});

                    }
				}
			}
		}
    }


    /**
     * Ha van file a formban akkor elmenti úgy pl.: Public_path() -ban
     * 'file/'.$this->crud_data['controller'].'/'.$item->id.$request['filname']
     * Ha a modelja use Thumbnail; akkor meghívja
     * @param $item egy crud model eleme
     * @param $request
     */
    public function fileUpload($item, $request){


		if(!empty($this->_fields)) {
			foreach ($this->_fields as $field_key=>$field) {

				if(!in_array($field->getType(), ['image', 'file', 'video']) )continue;
				if(empty($request->file($field_key)))continue;

				//ALAP file másolás a helyére
				$file_path = $this->generateFilePath($this->crud_data['url'],$item->id);


				//File elérése
                $path = $field->getPath();
				if(!empty($path)){
					$path_field_name = $field->getPath();
					$item->$path_field_name = $file_path;
				}


                $file_name = $request->file($field_key)->getClientOriginalName();
                $ext = $request->file($field_key)->getClientOriginalExtension();
                $file_name = StrHelper::slug_file_name($file_name, $ext,'_');

				$item->$field_key= $file_name;
				$item->save();

				//Fájl másolás
				$request->$field_key->move(public_path($file_path),$file_name);

				// Ha a modelben be van állítvan hogy csináljon egyéb képet akkor legenerálja
				if(method_exists($this->crud_data['model_class'], 'generateThumbnail')){

					$item->generateThumbnail();
				}

			}
		}

    }


    /**
     * Elkészít egy CSV filet a megadott itemekből
     *
     * @param App\Model\Transporter
     * @param string $file_name
     * @return array $file_data['path'] = var/www....   ; $file_data['url'] = http.....
     */
    public function makeCSVfile($items){

        $export_elements = $this->getExportElements($items);
        $file_name = $this->crud_data['url'].'.csv';
        $file_path = public_path('csv'.'/'.$file_name);
        $handle = fopen($file_path, 'w+');
        $thead = CsvHelper::encodeCSVLine($export_elements['thead']);
        fputcsv($handle, $thead, ";");

        foreach($export_elements['tbody']  as $element) {

            $tbody = CsvHelper::encodeCSVLine($element);
            fputcsv($handle, $tbody, ";");
        }
        fclose($handle);
        return [
            'path' => $file_path,
            'file_name' => $file_name,
        ];

    }

    /**Expotáláshoz szükséges elemeket állítja elő
     * @param $items azok az elemek amik az exportba kellenek
     * @return array[
     *          'thead' => $thead,
     *           'tbody' => $tbody]
     */
    public function getExportElements($items){


        $special_type = ['select','multiple_order','select2','slide'];

        //thead
        foreach ($this->_fields as $field_key =>$field) {

			$type = $field->getType();
			$label = $field->getLabel();

            if(!empty($label)
                && !in_array($type , $special_type)
            ){
                $thead[$field_key] = $label;
            }

            if(in_array($type , $special_type)){

                if($type == 'select'){
                    foreach ($field->getIndex() as $item) {
                        $thead[$field->getRelationMethod().'|||'.$item['col']] = $item['label'];
                    }
                }

                if($type == 'multiple_order' || $type == 'select2'){
                    $thead[$field_key.'___'.$field->getIndexShow()] = $item['label'];
                }

                if($type == 'slide'){
                    $thead[$field_key.'###slide_vagyok'] = $label;
                }

            }

        }
        dd($thead);


        //tbody
        foreach ($items as $item) {

            $row = null;
            foreach ($thead as $fieald_key =>$field) {


                if(strpos($fieald_key, '___') !== false){ // ManyToMany
                    $relation_array = explode('___' , $fieald_key);
                    $relation = $relation_array[0];
                    $col = $relation_array[1];

                    $list = '';
                    foreach ($item->$relation as $realtion_model) {
                        $list .= $realtion_model->$col.', ';
                    }
                    $row[$fieald_key] =$list;

                }
                elseif(strpos($fieald_key, '|||') !== false){ // OneToMany
                    $relation_array = explode('|||' , $fieald_key);
                    $relation = $relation_array[0];
                    $col = $relation_array[1];
                    $row[$fieald_key] = $item->$relation->$col;
                }elseif(strpos($fieald_key, '###slide_vagyok') !== false){ //Slide
                    $slide_array = explode('###slide_vagyok' , $fieald_key);
                    $slide = $item->slideImage;
                    if(is_null($slide)){ //slide_id ad vissza
                        $row[$slide_array[0]] = $item->$fieald_key;
                    }else{ //getImageUrl
                        $row[$slide_array[0]] = $slide->getImageUrl('image');
                    }


                }else{ //táblában lévő mezők
                    $row[$fieald_key] = $item->$fieald_key;
                }

            }
            $tbody[]=$row;
        }

        return [
            'thead' => $thead,
            'tbody' => $tbody
        ];
    }

    /**
     * Generál id és contorller alapján fájl elérési utat
     * @param string $controller_name
     * @param integer $id elmentett elem id ja
     * @return string  file/crud_example/0/0021/
     */
    public function generateFilePath($controller_name ='base', $id){
        $padding_id = str_pad($id,4,0,STR_PAD_LEFT);

        return 'file'.'/'
        .$controller_name.'/'
        .$padding_id[0].'/'
        .$padding_id.'/';
    }

    public function getCrudData(){
        return $this->crud_data;
    }

    public function getModel(){
        return $this->crud_data['model_class'];
    }

    public function getViewPath(){
        return $this->view_path;
    }

    /**
     *
	 * Összeszedi a CRUD field-et panel struktúrától függetlenül, és eltárolja a _fields property-be
     * @return array $fields
     */
    public function setAllFields() {
		$this->_fields = [];
		$this->index_fields = [];

		$need_sort = false;

//        dd($this->crud_data['panels']);
		if(!empty($this->crud_data['panels'])) {
			foreach($this->crud_data['panels'] as $panel) {
                if($panel->hasRows()) {
					$rows = $panel->getRows();
                    foreach($rows as $row) {
						if($row->hasFields()) {
							$fields = $row->getFields();

							foreach($fields as $field) {
								if(!$field->isHideIndex()) {
									$this->index_fields[$field->getName()] = $field;
									$field->getIndexOrder() != 1000 ? $need_sort = true : '';
								}
								if(!$field->isHideEdit()) {
									//var_dump($field->getName());
									$this->_fields[$field->getName()] = $field;
								}
							}
						}
                    }
                }
			}
		}
        $sort_array = [];
		if($need_sort){ // Sorrendbe rakja
            foreach ($this->index_fields as $key => $field) {
                $sort_array[$key]  = $field->getIndexOrder();
            }
            array_multisort($sort_array, SORT_ASC, $this->index_fields);
		}


//		dd($this->index_fields);
		return $this->_fields;
    }

    /**
     * Visszaadja az összes field-et panel struktúrától függetlenül
     * @return array $fields
     */
    public function getAllFields() {
		//Ha még nincsenek a field-ek összeszedve.
		if(empty($this->_fields)) {
			$this->setAllFields();
		}

		return $this->_fields;
    }

    /**
     * Visszaadja az összes index nézeten megjelenítendő
     * @return array $fields
     */
    public function getIndexFields() {

		//Ha még nincsenek a field-ek összeszedve.
		if(empty($this->index_fields)) {
			$this->setAllFields();
		}

		return $this->index_fields;
    }


	protected function _insertPanelBefore($panelName, $newPanel) {

		$result = false;

		if (!empty($this->crud_data['panels'])) {
			$new = array();

			foreach ($this->crud_data['panels'] as $panel) {

				if ($panel->getName() === $panelName) {
					$new[] = $newPanel;
					$result = true;
				}
				$new[] = $panel;
			}
			$this->crud_data['panels'] = $new;
		} else {
			$this->crud_data['panels'][] = $newPanel;
		}
		return $result;
	}


    /**
     * Tagek mentése
     * @param $item
     * @param $request
     */
    protected function setTags($item, $request)
    {
        if(!empty($this->_fields))
            {
                foreach ($this->_fields as $field)
                    {
                        if( $field->getType() == 'tags' && !empty($request->{$field->getName()}) ){
                            $item->retag($request->{$field->getName()});
                        }
                    }
            }


    }


    /**
     * Betölti a tageket edit és create nél. Szükség esetén controllerben lehet overridolni.
     * @param      $field
     * @param null $item
     */
    public function loadTags($field, $item = null)
    {
        //dump($item);
        //dd($field);
        if(is_null($item)){ // Createnél feltölti a tömböt
            //Amiket választani lehet
            $model = new $this->crud_data['model_class'];
            $existing_tags = $model->existingTags();
            $field->setOptionFrom($existing_tags);


        }else{ /// Editnél tölti fel a tömböt
            //belongsToMany
            //Amik már vannak
            $used_tags = $item->tags;
            $field->setOptionTo($used_tags);

            //Amiket választani lehet
            $model = new $this->crud_data['model_class'];
            $existing_tags = $model->existingTags();
            $field->setOptionFrom($existing_tags);
        }
    }

    /**
     * Visszaadja az összes tag-et tartalomtípus és nyelvenként
     * Paraméterezhető: kulcsszó alapján
     * AJAX kérés
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTagsJson(Request $request)
    {
        //keresett kulcsszó ha van
        $keyword = $request->has('keyword') ? $request->input('keyword') : null;

        //csak id és name
        $tags = CmsTag::query()->select(['id', 'name']);

        //ha van keresett kifejezés akkor szűrünk
        if($keyword){
            $tags->where('name', 'like', '%'.$keyword.'%');
        }
        //limit 10
        $keywords = $tags->take(10)->get();

        return response()->json([
            'keywords' => $keywords,
        ]);

    }


    public function sendCacheRefreshRequest()
    {
        $content_package = ContentPackage::find(Session::get('content_package_id'));
        $token = md5(date('Y-m-d').static::MAGIC_NUMBER);
        $client = \Guzzle::get($content_package->frontend_url.'/refreshcache/'.$token);
    }


    /**
     * Készít egy klónt egy megadott elemről
     * @param $id
     * @return Redirect editre
     */
    public function makeClone($id){
        $model = new $this->crud_data['model_class'];
        $original_item = $model->find($id);
        $clone = $original_item->replicate();
        $clone->save();
        return redirect(url('/'.$this->crud_data['url'].'/'.$clone->id.'/edit'));
    }

    /** Indexen keresési feltételek alapján megszűri a modelt
     * @param $request
     * @return mixed
     */
    public function FileterSearchValue($model, $crud_data, $search_value, $fields){
        // Mégse Mentés gombokhoz kell
        session(['search_value' => $search_value->all()]);

        if(!empty($crud_data['search'])) {

            foreach ($crud_data['search'] as $field_key => $field_value) {

                if($search_value->$field_key != ''){
                    switch ($field_value['type']) {
                        case 'select':
                        case 'hidden':
                            $model = $model->where($field_key , $search_value->$field_key);
                            break;
                        case 'link_select':
                            $model = $model->where($field_key , $search_value->$field_key);
                            break;
                        case 'tree_select':
                            $model = $model->where($field_key , $search_value->$field_key);
                            break;
                        case 'autocomplete':
                            $model = $model->where($field_key , $search_value->$field_key);
                            break;
                        case 'boolean':
                            $model = $model->where($field_key , $search_value->$field_key);
                            break;
                        case 'text':

                            //ha csak megadott mezőkben kell keresni
                            $search_filter = isset($field_value['search_in']) ? $field_value['search_in'] : null;

                            $search_cols = []; // azok a mezők amikbe kell a LIKE
                            $search_val = $search_value->$field_key;// a keresett string

                            //ha van beállított kereső filter de csak 1
                            if(isset($search_filter) && count($search_filter) == 1) {

                                $model = $model->where($field_value['search_in'][0], 'LIKE', '%' . $search_val . '%');

                            }else{//több mezőben keresünk

                                foreach ($fields as $key => $f_value) {
                                    //text mezőkben szűr + (ha be van állítva hogy pontosan melyik mezőbe keressen VAGY nincs semmi beállítva mező szűrés akkor az összes)
                                    if ($f_value->getType() == 'text' && ((isset($search_filter) && in_array($key, $search_filter)) || !isset($search_filter))) {
                                        $search_cols[] = $key;
                                    }
                                }

                                $model = $model->where(function ($query) use ($search_cols, $search_val) {
                                    foreach ($search_cols as $search_col) {
                                        $query->orWhere($search_col, 'LIKE', '%' . $search_val . '%');
                                    }
                                });

                            }

                            break;
                        case 'daterangepicker':
                            $from_to = explode(' - ' , $search_value->$field_key);
                            $model = $model->whereBetween($field_key, $from_to);
                            break;
                        case 'may_to_may': // Több több kapcsolatos keresés
                            $key_id =$search_value->$field_key;
                            $model = $model
                                ->whereHas($field_key, function($q)use($key_id){
                                    $q->where('id', $key_id);
                                });

                            break;
                        default:

                            break;
                    }
                }

            }
        }

        //Keresési adatok paginatelve is mennyenek
        return $model;
    }

    /**Sorrend állítás indexnél
     * @param $model
     * @return mixed
     */
    public function OrderItem($model){
        return $model;
    }

    /**
     * Az indexben lehet a querynek + paramétereket adni, ha a kontrolerben overridolod ezt a függvényt
     * @param $query
     * @return mixed
     */
    public function indexCustomConditions($model){
        return $model;
    }


    public function setSearchData($model, $crud_data, $fields){
        $view = [];


        if(!empty($crud_data['search'])) {
            foreach ($crud_data['search'] as $search_key=>&$search_value) {
                switch ($search_value['type']) {

                    case 'boolean':
                        $label = '';
                        if(!empty($search_value['label'])) {
                            $label = $search_value['label'];
                        } else if(!empty($fields[$search_key]->getLabel())) {
                            $label = $fields[$search_key]->getLabel();
                        }

                        $view[$search_key] =[
                            'type'  => $search_value['type'],
                            'empty' => (!empty($search_value['empty']) ? $search_value['empty'] : 'Összes' ),
                            'label' => $label,
                        ];
                        break;
                    case 'select':
                        $label = '';
                        if(!empty($search_value['label'])) {
                            $label = $search_value['label'];
                        } else if(!empty($fields[$search_key]->getIndex()[0]['label'])) {
                            $label = $fields[$search_key]->getLabel();
                        }

                        $view[$search_key] =[
                            'type'  => 'select',
                            'disabled' => !empty($search_value['disabled']),
                            'empty' => (!empty($search_value['empty']) ? $search_value['empty'] : 'Összes' ),
                            'label'     => $label,
                        ];
                        if(!empty($search_value['options'])) {
                            $view[$search_key]['options'] = $search_value['options'];
                        } else {
                            $view[$search_key]['options'] = $fields[$search_key]->getOptions();
                        }
                        break;
                    case 'link_select': // olyan mezők amik valamilyen relációval tudjuk meg a megjelenítendő nevet
                        // pl. user_group_id a selectben nem az id akarjuk hanem a group nevét

                        $options = [];
                        if(!empty($search_value['options'])) {
                            $options = $search_value['options'];
                        } else if(isset($fields[$search_key])) {
                            $options = $fields[$search_key]->getOptions();
                        }
                        $label = '';
                        if(!empty($search_value['label'])) {
                            $label = $search_value['label'];
                        } else if(!empty($fields[$search_key]->getIndex()[0]['label'])) {
                            $label = $fields[$search_key]->getIndex()[0]['label'];
                        }

                        $view[$search_key] =[
                            'type'  => 'select',
                            'disabled' => !empty($search_value['disabled']),
                            'empty' => (!empty($search_value['empty']) ? $search_value['empty'] : 'Összes' ),
                            'label'     => $label,
                            'options'   => $options,
                        ];
                        break;
                    case 'tree_select':
                        $options = [];
                        if(!empty($search_value['options'])) {
                            $options = $search_value['options'];
                        } else if(isset($fields[$search_key])) {
                            $options = $fields[$search_key]->getOptions();
                        }
                        $label = '';
                        if(!empty($search_value['label'])) {
                            $label = $search_value['label'];
                        } else if(!empty($fields[$search_key]->getLabel())) {
                            $label = $fields[$search_key]->getLabel();
                        }


                        $view[$search_key] =[
                            'type'  => 'select',
                            'disabled' => !empty($search_value['disabled']),
                            'empty' => (!empty($search_value['empty']) ? $search_value['empty'] : 'Összes' ),
                            'label'     => $label,
                            'options'   => $options,
                        ];
                        break;
                    case 'autocomplete':
                        $label = '';
                        if(!empty($search_value['label'])) {
                            $label = $search_value['label'];
                        } else if(!empty($fields[$search_key]->getIndex()[0]['label'])) {
                            $label = $fields[$search_key]->getLabel();
                        }

                        $view[$search_key] =[
                            'type'  => 'autocomplete',
                            'disabled' => !empty($search_value['disabled']),
                            'empty' => (!empty($search_value['empty']) ? $search_value['empty'] : '' ),
                            'label'     => $label,
                            'autocomplete_text_value' => $fields[$search_key]->getAutocompleteTextValue(),
                            'ajax_id' => $fields[$search_key]->getAjaxId(),
                            'source' => $fields[$search_key]->getSource(),
                            'target' => $fields[$search_key]->getSource(),
                        ];
                        break;
                    case 'may_to_may': // select2 , multiple_order típusnál használható
                        $controller = new $crud_data['controller_path']();
                        $fv = $search_value['setSearchOptions'];
                        $options = $controller->$fv();
                        $view[$search_key] =[
                            'type'  => 'select',
                            'disabled' => !empty($search_value['disabled']),
                            'empty' => (!empty($search_value['empty']) ? $search_value['empty'] : 'Összes' ),
                            'label'     => array_key_exists('label', $search_value) ? $search_value['label'] : $fields[$search_key]->getLabel(),
                            'options'   => $options,
                        ];

                        break;
                    case 'hidden':
                        $view[$search_key] =[
                            'type'  => $search_value['type'],
                        ];
                        break;
                    default: // text , boolean, daterangepicker
                        $view[$search_key] =[
                            'type'  => $search_value['type'],
                            'label' => array_key_exists('label', $search_value) ? $search_value['label'] : $fields[$search_key]->getLabel(),
                        ];

                        break;
                }

            }
        }

        return $view;
    }


}
