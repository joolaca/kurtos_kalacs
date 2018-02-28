<?php
/**
 * Created by PhpStorm.
 * User: erik
 * Date: 3/20/17
 * Time: 8:56 AM
 */

namespace App\Http\Fields;

/**
 * Class TagsField - Címke mező
 * @package App\Http\Fields
 */
class TagsField extends MultiSelectField
{
    protected $type = 'tags';
	protected $hide_index = true;

    protected $input_options = [
        /*
        DEFAULTS
        'minLength' => 3,
        'highlight' => true,
        'displayKey' => 'name',
        'valueKey' => 'name'
        */
    ];

    public function __construct($name)
    {

        $this->setAjaxURL('ajax/get_tags_json');

        parent::__construct($name);
    }


    public function getFormHtml($item = null){

        $options = [];

        foreach ($this->option_from as $option_key => $option) {
            $selected = '';
            if(array_key_exists($option_key,$this->option_to)){
                $option_str = "<option value='$option_key'>$option</option>";
                $options[] = $option_str;
            }
        }

        $field = $this;
        return view('common/fields/edit_elements/tags' , compact('options' , 'field'))->render();

    }



    public function setOptionFrom($option_from)
    {
        $tags = array();
        foreach($option_from as $from)
            {
                if(!empty($from))
                    {
                        $tags[$from->name] = $from->name;
                    }
            }
        $this->option_from = $tags;

        return $this;
    }



    public function setOptionTo($option_to)
    {
        foreach($option_to as $to)
            {
                if(!empty($to))
                    {
                        $this->option_to[$to->name] = $to->name;
                    }
            }
        return $this;
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
        if(!$this->hide_index)
        {
            $used_tags = $item->tags;
            $last_tag = "";
            foreach($used_tags as $tag)
                {
                    $value .= !empty($tag->name) ? $tag->name.', ' : '';
                    $last_tag .= !empty($tag->name) ? $tag->name.', ' : '';
                }

            $value = !empty($last_tag) ? substr($value, 0, -2) : $value;
        }
        $value .='</td>';

        return $value;
    }


    /**
     * @return array
     */
    public function getInputOptions()
    {
        return $this->input_options;
    }

    /**
     * @return json encoded string
     */
    public function showInputOptions()
    {
        if(!empty($this->input_options)){

            return json_encode($this->input_options);
        }
    }

    /**
     * @param array $input_options
     */
    public function setInputOptions($input_options)
    {
        foreach($input_options as $key => $option)
        {
            if(!empty($option) && !empty($option))
            {
                $this->input_options[$key] = $option;
            }
        }
        return $this;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setAjaxURL($url){

        if(!empty($url)){
            $this->input_options['ajax_url'] = url($url);
        }
        return $this;
    }

}