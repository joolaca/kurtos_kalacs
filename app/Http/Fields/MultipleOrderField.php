<?php

namespace App\Http\Fields;

/**
 * Class MultipleOrderField - Sorrendezhető többszörös választó mező
 * @package App\Http\Fields
 */
class MultipleOrderField extends MultiSelectField
{

    protected $type = 'multiple_order';

    protected $include_scripts = [];

    /**
     * @return array
     */
    public function getIncludeScripts()
    {
        return $this->include_scripts;
    }

    /**
     * @param array $include_scripts
     */
    public function setIncludeScripts($include_scripts)
    {
        foreach ((array) $include_scripts as $value){

            $this->include_scripts[] = $value;

        }
        return $this;
    }

    public function getFormHtml($item = null){

        $options = [
            'option_from' => $this->option_from,
            'option_to' => $this->option_to,
        ];
        $field = $this;

		$required = false;
		if($this->hasValidaionRule('required')) {
			$required = true;
		}

        return view('common/fields/edit_elements/multiple_order' , compact('options' , 'field', 'required'))->render();

    }

}