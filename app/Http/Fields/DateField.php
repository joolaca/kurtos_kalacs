<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 14:43
 */

namespace App\Http\Fields;

/**
 * Class DatetimeField - Naptáros dátum választó
 * @package App\Http\Fields
 */
class DateField extends TextField
{
    protected $type = 'datepicker';
    protected $attributes = ['class' => 'form-control datepicker'];
	protected $icon = 'calendar';

    protected $blade_edit_location = 'common/fields/edit_elements/date';

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