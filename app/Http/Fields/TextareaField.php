<?php

namespace App\Http\Fields;

/**
 * Class TextareaField - Szöveg doboz mező
 * @package App\Http\Fields
 */
class TextareaField extends Field
{

    protected $type = 'textarea';
	protected $hide_index = true;
    protected $include_scripts = [];

    protected $blade_edit_location = 'common/fields/edit_elements/textarea';
    /**
     * Index mezőként nem szereplhet -> setter nem csinál semmit
     */
    public function setHideIndex($hide_index)
    {
        return $this;
    }

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

        $field = $this;

        return view($this->getBladeEditLocation() , compact('field','item'))->render();
    }

}