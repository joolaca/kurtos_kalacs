<?php

namespace App\Http\Fields;
use Illuminate\Support\Facades\Log;

/**
 * Abstract Class Field - Form mező absztakt osztály
 * @package App\Http\Fields
 */
abstract class Field
{

    protected $name = ''; //field id-ja és name-je
    protected $label = ''; //field-hez tartozo label szovege
    protected $type = ''; //field típusa
    protected $validation_rules = ''; //laravel validalo szabalyok
    protected $default = null; //alapértelmezett érték beállítása
	protected $popover = ''; // ha valamilyen különleges classt beállítanak
    protected $permission = true;// Szerkesztheti az elemet van input...

    protected $hide_index = FALSE; //elrejtjuk az index oldalon
    protected $hide_edit = FALSE; //elrejtjuk az edit/create oldalon
    protected $setup_function = ''; //a gyerek kontrollerben meghatározott fv amivel be lehet állítani a default/option értékeket

    protected $blade_edit_location = '';//edit blade elérési útja a resources mappában
    protected $blade_html_extensions_location = 'common/fields/elements_html_extensions/elements';//extra html tartalmak blade elérési útja a resources mappában
    protected $index_order = 1000;

    protected $index_td_class = "";

    /**
     * @return string
     */
    public function getIndexTdClass(): string
    {
        return $this->index_td_class;
    }

    /**
     * @param string $index_td_class
     */
    public function setIndexTdClass(string $index_td_class)
    {
        $this->index_td_class = $index_td_class;
        return $this;
    }

    /**
     * field html attributes
     *
     * @var array
     */
    protected $attributes = ['class' => 'form-control']; //field attributumok

    /**
	 * HTML Form-okhoz
	 * @param $item
	 *
     * @return \Illuminate\Http\Response
     */
    abstract public function getFormHtml($item = null);

    public function __construct($name)
    {
        $this->name = $name;
		$this->attributes['id'] = $this->name;
    }

    /**
     * Index oldalon a tablazat fejleceben megjeleno szoveg
	 *
	 * @param string $sortCol sorrendezés oszlopa
     * @param string $direction sorrend iránya
	 *
     * @return string
     *
     */
    public function showTableHeadCell($sortCol = null, $direction = null)
    {
		$colHtml = '';
		if(!empty($sortCol) && !empty($direction) && $sortCol == $this->name) {
			$colHtml = '<th class="sorting '.$direction.'" data-sort-field="'.$this->name.'">'.$this->label.'</th>';
		} else {
			$colHtml = '<th class="sorting" data-sort-field="'.$this->name.'">'.$this->label.'</th>';
		}
        return $colHtml;
    }

    /**
     * Index oldalon a tablazat cellában megjeleno érték
	 *
	 * @param object $item
     *
     * @return string
     *
     */
    public function showTableCell($item)
    {
		$value = null;
		if(!$this->hide_index) {
			$value = '<td class="'.$this->getIndexTdClass().'">'.strip_tags($item->{$this->name} ).'</td>';
		} else {
			$value ='<td></td>';
		}

		return $value;
    }

    /**
	 * Editnél megjelenítő érték, create nél ha van akkor default ha nincs akkor null értéket ad vissza
     * @param $item
     * @return mixed|string
     */
    public function getItemValue($item){
        $value = '';

        if(!is_null($item) && isset($item->{$this->getName()}) && !is_null($item->{$this->getName()})){

            $value = $item->{$this->getName()};
        }else{
            $value = $this->default;
        }
        return $value;
    }


    /* -----------------------------------------
     *  GETek SETek
     ------------------------------------------*/
    /**
	 * Mező neve
	 *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
	 * HTML attribútumok. Az összes, vagy ha van key param átadva, akkor az ahhoz tartozó érték
	 *
     * @erturn mixed $attributes
     */
    public function getAttributes($key = null)
    {
        if($key === null){ // az egész attribute tömböt visszadjuk
            return $this->attributes;
        }elseif(array_key_exists($key, $this->attributes)){//visszaadjuk az attribute tömbből a $key értékét, ha létezik
            return $this->attributes[$key];
        }else{//ha nincs benne az attribute tömmben akkor null értéket adunk vissza
            return null;
        }
    }

    /**
	 * HTML attribútumok
	 *
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {

        foreach ((array) $attributes as $name => $value){

            $this->attributes[$name] = $value;

        }
        return $this;
    }

    /**
	 * Mező felirata
	 *
     * @return string $label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
	 * Mező felirata
	 *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
	 * Mezőre szintű jogosultság kezeléshez szabályok
	 *
     * @return string $permission
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
	 * Mezőre szintű jogosultság kezeléshez szabályok
	 *
     * @param string $permission
     */
    public function setPermission($permission)
    {
        return $this->permission = $permission;
    }

    /**
	 * Mező típusa
	 *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
	 * Mezőre vonatkozó validációs szabályok
	 *
     * @return string $validation_rules
     */
    public function getValidationRules()
    {
        return $this->validation_rules;
    }

    /**
	 * Mezőre vonatkozó validációs szabályok
	 *
     * @param string $validation_rules
     */
    public function setValidationRules($validation_rules)
    {
        $this->validation_rules = $validation_rules;
        return $this;
    }

    /**
	 * Mező edit form láthatóság beállítás
	 *
     * @return boolean $isHideIndex
     */
    public function isHideIndex()
    {
        return $this->hide_index;
    }

    /**
	 * Mező edit form láthatóság beállítás
	 *
     * @return boolean $isHideEdit
     */
    public function isHideEdit()
    {
        return $this->hide_edit;
    }

    /**
	 * Mező listanézet láthatóság beállítás
	 *
     * @param string $hide_index
     */
    public function setHideIndex($hide_index)
    {
        $this->hide_index = $hide_index;
        return $this;
    }

    /**
	 * Mező edit form láthatóság beállítás
	 *
     * @param string $hide_edit
     */
    public function setHideEdit($hide_edit)
    {
        $this->hide_edit = $hide_edit;
        return $this;
    }

    /**
	 * Alapértelmezett érték
	 *
     * @return string $default
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
	 * Alapértelmezett érték
	 *
     * @param string $default
     */
    public function setDefault($default){
        $this->default = $default;
        return $this;
    }

    /**
	 * Mező inicializásló függvény neve
	 *
     * @param string $str
     */
    public function setSetupFunction($str){
        $this->setup_function = $str;
        return $this;
    }

    /**
	 * Mező inicializásló függvény neve
	 *
     * @return string
     */
    public function getSetupFunction(){
        return $this->setup_function;

    }

    /**
	 * Info box tartalma
	 *
     * @param string $popover
     */
    public function setPopover($popover){
        $this->popover = $popover;
        return $this;
    }

    /**
	 * Info box tartalma
	 *
     * @return string
     */
    public function getPopover(){
        return $this->popover;
    }

    /**
	 * Info box HTML tartalma
	 *
     * @return string
     */
	public function getPopoverHtml() {

		$out = '';
		return $out;

	}

    /**
	 * Rendelkezik-e a field a parméterként kapott validációs szabállyal
	 *
	 * @param string $rule
     * @return boolean
     */
	public function hasValidaionRule($rule) {
		$ret = false;

		if(!empty($this->validation_rules)) {
			$rules = explode('|', $this->validation_rules);

			if(in_array($rule, $rules)) {
				$ret = true;
			}
		}


		return $ret;
	}

    /**
	 * Edit blade elérése
	 *
     * @return string
     */
    public function getBladeEditLocation()
    {
        return $this->blade_edit_location;
    }

    /**
	 * Edit blade elérése
	 *
     * @param string $blade_edit_location
     */
    public function setBladeEditLocation($blade_edit_location)
    {
        $this->blade_edit_location = $blade_edit_location;
		return $this;
    }

    /**
	 * Extension blade elérése
     * @return string
     */
    public function getBladeHtmlExtensionsLocation()
    {
        return $this->blade_html_extensions_location;
    }

    /**
	 * Extension blade elérése
	 *
     * @param string $blade_html_extensions_location
     */
    public function setBladeHtmlExtensionsLocation($blade_html_extensions_location)
    {
        $this->blade_html_extensions_location = $blade_html_extensions_location;
		return $this;
    }

    /**
     * Index oldalon ha beállítják akkor sorrendbe rakja
     * alapból mindenkinek 1000
     */
    public function setIndexOrder($num){
        $this->index_order = $num;
        return $this;
    }

    /**
     * Index oldalon ha beállítják akkor sorrendbe rakja
     */
    public function getIndexOrder(){
        return $this->index_order;
    }
}