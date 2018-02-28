<?php

namespace App\Http\Fields;

/**
 * Class StaticSelectField - Egyszerű, model kapcsolat nélküli legördülő lista mező
 * @package App\Http\Fields
 */
class StaticSelectField extends Field
{

    protected $type = 'static_select';

    protected $options = [];

    protected $placeholderOption = [];

    protected $blade_edit_location = 'common/fields/edit_elements/staticselect';


    public function __construct($name)
    {
        //alapértelmezetten első opció hozzáadódik, levételéhez a setPlaceholderOption(NUll) kell használni
        $this->setPlaceholderOption(trans('crud.select.first_option_name'));

        parent::__construct($name);
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOption($id)
    {

        return (array_key_exists($id, $this->options) ? $this->options[$id] : null);
    }

    public function setOptions($options){
        $this->options = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function getPlaceholderOption()
    {
        return $this->placeholderOption;
    }

    /**
     * @param array $placeholderOption
     */
    public function setPlaceholderOption($placeholderOption, $defaultValue = NULL)
    {

        if($placeholderOption === NULL){

            unset($this->placeholderOption);

        }else{

            $this->placeholderOption = [$defaultValue => $placeholderOption];

        }

        return $this;
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
        if(!$this->hide_index && $item->{$this->name} !== NULL) {

            $value = '<td class="'.$this->getIndexTdClass().'">'.$this->getOption($item->{$this->name}).'</td>';
        } else {

            $value ='<td></td>';
        }

        return $value;
    }


    /**
	 * HTML Form-okhoz
	 * @param $item
	 *
     * @return \Illuminate\Http\Response
     */
    public function getFormHtml($item = null){
		if(!empty($this->placeholderOption)) {


			$options = (array)$this->placeholderOption + (array)$this->getOptions();
		}
        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'item', 'options'))->render();
    }




}