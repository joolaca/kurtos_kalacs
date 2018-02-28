<?php

namespace App\Http\Fields;

/**
 * Class MultiSelectField - Többszörös választó mező
 * @package App\Http\Fields
 */
class MultiSelectField extends SelectField
{

    protected $type = 'select2';

    protected $option_from = [];
    protected $option_to = [];

    protected $setOptions = '';



    /**
     * @return string
     */
    public function getIndexShow()
    {
		$index_show = null;
		if(isset($this->index[0]['col'])) {
			$index_show = $this->index[0]['col'];
		}
        return $index_show;
    }


    public function setOptionFrom($option_from)
    {
        $this->option_from = $option_from;
        /*
        foreach ((array) $option_from as $name => $value){

            $this->option_from[$name] = $value;

        }*/
        return $this;
    }
    public function getOptionFrom()
    {
        return $this->option_from;
    }


    public function getOptionTo()
    {
        return $this->option_to;
    }


    public function setOptionTo($option_to)
    {
        foreach ((array) $option_to as $name => $value){

            $this->option_to[$name] = $value;

        }
        return $this;
    }

    /**
     * @return string
     */
    public function getSetOptions()
    {
        return $this->setOptions;
    }

    /**
     * @param string $setOptions
     */
    public function setSetOptions($setOptions)
    {
        $this->setOptions = $setOptions;
        return $this;
    }

    /**
     * Index oldalon a tablazat fejleceben megjeleno szoveg
     *
	 *
	 * @param string $sortCol sorrendezés oszlopa
     * @param string $direction sorrend iránya
	 *
     * @return string
     *
     */
    public function showTableHeadCell($sortCol = null, $direction = null)
    {
        return '<th>'.$this->label.'</th>';
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

		$value = '<td class="'.$this->getIndexTdClass().'">';
		if(!$this->hide_index && !is_null($item->{$this->name} )) {

			foreach($item->{$this->name} as $k=>$val) {

				 $value .=  (($k)?', ':'').$val->{$this->getIndexShow()};

			}
		}
		$value .='</td>';

		return $value;
    }

    /**
	 * HTML Form-okhoz
	 * @param $item
	 *
     * @return \Illuminate\Http\Response
     */
    public function getFormHtml($item = null){

        $options = [];

        foreach ($this->option_from as $option_key => $option) {
            $selected = '';
            if(array_key_exists($option_key,$this->option_to)){
                $selected = 'selected';
            }

            $option_str = "<option value='$option_key' $selected>$option</option>";
            $options[] = $option_str;
        }

        $field = $this;

		$required = false;
		if($this->hasValidaionRule('required')) {
			$required = true;
		}

        return view('common/fields/edit_elements/multi_select' , compact('options' , 'field', 'required'))->render();

    }

}