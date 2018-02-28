<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 14:43
 */

namespace App\Http\Fields;

/**
 * Class NumberField - Szám mező
 * @package App\Http\Fields
 */
class NumberField extends TextField
{
    protected $type = 'number';

    protected $blade_edit_location = 'common/fields/edit_elements/number';

    public function getFormHtml($item = null){

        $value = $this->getItemValue($item);
        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'value'))->render();
    }


}