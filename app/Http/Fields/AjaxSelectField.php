<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 15:52
 */

namespace App\Http\Fields;

use League\Flysystem\Exception;
/**
 * Class AjaxSelect - Ajax kiválasztó
 * @package App\Http\Fields
 */
class AjaxSelectField extends SelectField
{

    protected $type = "ajax_select";
	protected $value = null;
    protected $blade_edit_location = 'common/fields/edit_elements/ajax_select';
    protected $ajax_id = 'ajax_select';
    protected $source = null;
    protected $autocompletetextvalue = "";

    /**
     * @return string
     */
    public function getAutocompleteTextValue()
    {
        return $this->autocompletetextvalue;
    }

    /**
     * @param string $autocompletetextvalue
     */
    public function setAutocompleteTextValue($autocompletetextvalue)
    {
        $this->autocompletetextvalue = $autocompletetextvalue;
    }

    /**
     * @return null
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param null $source
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return string
     */
    public function getAjaxId()
    {
        return $this->getName().'_'.$this->ajax_id;
    }

    protected $attributes = ['class' => 'form-control ajax_select']; //field attributumok

    /**
	 * Field értéke
	 *
     * @return string $value
     */
	public function getValue() {
		return $this->value;
	}

    /**
	 * Field értéke
	 *
     * @param string $value
     */
	public function setValue($value) {
		$this->value = $value;
	}


    /**
	 * HTML Form-okhoz
	 * @param $item
	 *
     * @return \Illuminate\Http\Response
     */
    public function getFormHtml($item = null){

        if(!$this->getSource()){
            throw new Exception("Nem adtad meg az ajax elérését (source)");
        }

        $this->setAttributes([
            'id' => $this->getAjaxId(),
            'data-target' => $this->getName()
        ]);

		if(!empty($this->value)) {
			$value = $this->value;
		} else {
			$value = $this->getItemValue($item);
		}
        $field = $this;

        return view($this->getBladeEditLocation() , compact('field', 'value'))->render();

    }
}