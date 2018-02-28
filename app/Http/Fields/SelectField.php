<?php

namespace App\Http\Fields;

/**
 * Class SelectField - Legördülő lista mező
 * @package App\Http\Fields
 */
class SelectField extends StaticSelectField
{

    protected $type = 'select';

    protected $optionsModel = '';// ide a modelt tolti bele

    protected $relation_method = '';//a kapcsolat belongsTo fuggvenye

    protected $index = [];// index oldalon mi jelenjen meg. label <th> ban; col <td> ben

    protected $edit = [];
    protected $set_options_function = '';

    protected $blade_edit_location = 'common/fields/edit_elements/select';


    /**
	 * Kapccsolódó model neve
	 *
     * @return string
     */
    public function getOptionsModel()
    {
        return $this->optionsModel;
    }

    /**
	 * Kapccsolódó model neve
	 * @param string $optionsModel
	 *
     * @return SelectField
     */
    public function setOptionsModel($optionsModel)
    {
        $this->optionsModel = $optionsModel;
        return $this;
    }

    /**
	 * Model kapcsolat methodus neve
	 *
     * @return string
     */
    public function getRelationMethod()
    {
        return $this->relation_method;
    }

    /**
	 * Model kapcsolat methodus neve
	 * @param string $relation_method
	 *
     * @return SelectField
     */
    public function setRelationMethod($relation_method)
    {
        $this->relation_method = $relation_method;
        return $this;
    }


    /**
	 * HTML Index nézeteken megejelenő oszlop neve
	 *
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
	 * HTML Index nézeteken megejelenő oszlop neve
	 * @param string $index
	 *
     * @return SelectField
     */
    public function setIndex($index)
    {
        foreach ((array) $index as $name => $value){

            $this->index[$name] = $value;

        }
        return $this;
    }

	/**
	 * HTML Edit nézeteken megejelenő oszlop neve
	 *
     * @return string
     */
    public function getEdit()
    {
        return $this->edit;
    }

    /**
	 * HTML Index nézeteken megejelenő oszlop neve
	 * @param string $edit
	 *
     * @return SelectField
     */
    public function setEdit($edit)
    {
        foreach ((array) $edit as $name => $value){

            $this->edit[$name] = $value;

        }
        return $this;
    }

    /**
     * Index oldalon a tablazat fejleceben megjeleno szoveg
	 *
	 * @param string $sortCol sorrendezés oszlopa
     * @param string $direction sorrend iránya
	 *
     * @return string
     */
    public function showTableHeadCell($sortCol = null, $direction = null)
    {
		$col = "";
		foreach($this->index as $element) {

			$sort_field = $this->relation_method.'___'.$element['col'];

			if(!empty($sortCol) && !empty($direction) && $sortCol == $sort_field) {
				$col .= '<th class="sorting '.$direction.'" data-sort-field="'.$this->relation_method.'___'.$element['col'].'">'.$element['label'].'</th>';
			} else {
				$col .= '<th class="sorting" data-sort-field="'.$sort_field.'">'.$element['label'].'</th>';
			}
		}
        return $col;
    }

    /**
     * Index oldalon a tablazat cellában megjeleno érték
	 * @param object $item
     * @return string
     */
    public function showTableCell($item)
    {
		$value = null;

		if(!$this->hide_index && !is_null($item->{$this->name} )) {

			foreach($this->index as $val) {
				 $value .= '<td class="'.$this->getIndexTdClass().'">'.$item[ $this->relation_method ] [ $val['col'] ].'</td>';
			}
		} else {
            foreach($this->index as $val) {
                $value .='<td></td>';
            }
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

        $value = '';
        if(!is_null($item)){
            $value = $item->{$this->getName()};
        }elseif (isset($this->default)){
            $value = $this->default;
        }
		//var_dump($this->options);die;
		if(!empty($this->placeholderOption)) {
			$options = $this->placeholderOption + $this->options;
		} else {
			$options = $this->options;
		}

        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'value', 'options', 'item'))->render();
    }



}