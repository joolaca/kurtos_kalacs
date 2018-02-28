<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 17:34
 */

namespace App\Http\Fields;

/**
 * Class SwitchField - Igen/Nem választó field. Boostrap switch
 * @package App\Http\Fields
 */
class SwitchField extends Field
{
    protected $type = 'switch';

    protected $blade_edit_location = 'common/fields/edit_elements/switch';

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
		$value = '<td class="'.$this->getIndexTdClass().'">';
		if(!$this->hide_index) {

			if($item->{$this->name} ) {
				$value .= '<span class="label label-sm label-success">'. trans('global.yes') .'</span>';
			} else {
				$value .= '<span class="label label-sm label-danger"> '. trans('global.no') .' </span>';
			}
		}
		$value .= '</td>';

		return $value;
    }

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