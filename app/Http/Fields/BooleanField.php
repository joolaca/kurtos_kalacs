<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 17:34
 */

namespace App\Http\Fields;

/**
 * Class BooleanField - Igen/Nem választó field. Select-es
 * @package App\Http\Fields
 */
class BooleanField extends SwitchField
{
    protected $type = 'boolean';

    protected $blade_edit_location = 'common/fields/edit_elements/boolean';



    /**
	 * HTML Form-okhoz
	 * @param $item
	 *
     * @return \Illuminate\Http\Response
     */
    public function getFormHtml($item = null){

        $value = $this->getItemValue($item);

        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'value'))->render();
    }
}