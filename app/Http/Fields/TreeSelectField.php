<?php

namespace App\Http\Fields;

/**
 * Class TreeSelectField - Fa struktúrűkhoz legördülő lista mező
 * @package App\Http\Fields
 */
class TreeSelectField extends StaticSelectField
{

    protected $type = 'static_select';

    protected $options = [];

    protected $placeholderOption = [];

    protected $blade_edit_location = 'common/fields/edit_elements/treeselect';

    /**
	 * Tree megejelenésű options-tömböt generál
	 *
     * @param Collection $options A tree első szintje
	 * @return object TreeSelectField $this
	 */
    public function setOptions($options){
		$res = [];
        if(!empty($options))
            {
                foreach($options as $item)
                    {
                        $level = -1;

                        //$res[$item->id] = $item->name;
                        if($item->children->count())
                            {
                                $child = $this->getChild($item->children, $level);
                                $res = $res + $child;
                            }
                    }
            }
        //dd($res);
        $this->options = $res;

        return $this;
    }

    /**
	 * Node gyekereihet tartalmazó tömböt állít elő
	 *
     * @param Collection $parent_childs
	 * @return array $res
	 */
    private function getChild($parent_childs, $level)
    {
        $level++;
        $res = [];
        foreach($parent_childs as $child)
            {
                if($level*1 > 0)
                    {
                        $name_pref = "";
                        for($i = 1; $i < $level; $i++)
                            {
                                $name_pref .= "&nbsp;&nbsp;&nbsp;";
                            }
                        $name_pref .= html_entity_decode('\'&mdash;', ENT_QUOTES, 'UTF-8');
                        //dump($name_pref);
                        $name = str_pad($child->name, (strlen($child->name) + strlen($name_pref)), $name_pref, STR_PAD_LEFT);
                    }
                else
                    {
                        $name = str_pad($child->name, (strlen($child->name) + $level*1*8), html_entity_decode('\'&mdash;', ENT_QUOTES, 'UTF-8'), STR_PAD_LEFT);
                    }
                //dump($name);
                $res[$child->id] = $name;

                if($child->children->count())
                    {
                        $child_result = $this->getChild($child->children, $level);
                        $res = $res + $child_result;
                    }
            }
        return $res;
    }

}