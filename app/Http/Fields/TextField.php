<?php

namespace App\Http\Fields;

/**
 * Class TextField - Szöveges mező
 * @package App\Http\Fields
 */
class TextField extends Field
{

    protected $type = 'text';
    protected $maxlength= '255';
    protected $placeholder= '';
	protected $icon= '';
    protected $addon= '';

    protected $blade_edit_location = 'common/fields/edit_elements/text';

    public function setMaxLength($item){
        $this->maxlength = $item;
        return $this;
    }
    public function getMaxLength(){
        return $this->maxlength;
    }

    public function setPlaceholder($item){
        $this->placeholder = $item;
        return $this;
    }

    public function getPlaceholder(){
        return $this->placeholder;
    }

    public function setIcon($item){
        $this->icon = $item;
        return $this;
    }

    public function getIcon(){
        return $this->icon;
    }

    public function setAddon($addon){
        $this->addon = $addon;
        return $this;
    }

    public function getAddon(){
        return $this->addon;
    }

    /* -----------------------------------------
     *  Függvények
     ------------------------------------------*/

    public function getFormHtml($item = null){
        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'item'))->render();
    }

}