<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 15:52
 */

namespace App\Http\Fields;

/**
 * Class HiddenField - Hidden mező
 * @package App\Http\Fields
 */
class HiddenField extends Field
{

    protected $type = "hidden";
    protected $hide_index = TRUE;
	protected $value = null;
    protected $blade_edit_location = 'common/fields/edit_elements/hidden';

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

		if(!empty($this->value)) {
			$value = $this->value;
		} else {
			$value = $this->getItemValue($item);
		}
        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'value'))->render();

    }
}