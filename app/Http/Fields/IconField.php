<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.28.
 * Time: 11:17
 */

namespace App\Http\Fields;


use League\Flysystem\Exception;

/**
 * Class IconField - Ikon kiválasztó mező
 * @package App\Http\Fields
 */
class IconField extends Field
{
    protected $type = 'icon';

    protected $blade_edit_location = 'common/fields/edit_elements/icon';

    protected $hide_index = true;

    protected $belongsto_relation = '';

    protected $validation_rules = 'nullable|integer';

    protected $icon;

    protected $has_icon = false;

    /**
     * @return string
     */
    public function getBelongstoRelation()
    {
        return $this->belongsto_relation;
    }

    /**
     * @param string $belongsto_relation
     */
    public function setBelongstoRelation($belongsto_relation)
    {
        $this->belongsto_relation = $belongsto_relation;
        return $this;
    }

    public function getFormHtml($item = null)
    {

        //ha üres a relation
        if(!$this->belongsto_relation){
            throw new Exception("Empty relation. ".$this->getName(). ' nél add meg a setBelongstoRelation-t');
        }

        //ha nincs ilyen relation method-ja error
        if($item !== null && method_exists($item, $this->belongsto_relation) === FALSE && !$this->has_icon){
            throw new Exception("Not found relation : " . $this->belongsto_relation);
        }

        $value = $this->getItemValue($item);
        $icon = empty($item) ? null : $item->{$this->getBelongstoRelation()};
        //ha üres a icon, megnézzük a icon mezőt is, mert lehet a moduloknál egy modultípus mezőjéről van szó,
        // az pedig értéket csak a icon paraméter alapján tudja átadni.
        if(empty($icon))
            {
                $icon = $this->getIcon();
            }

        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'item', 'value', 'icon'))->render();
    }


    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }


    /**
     * @param $icon
     *
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getHasIcon()
    {
        return $this->has_icon;
    }


    /**
     * @param $icon
     *
     * @return $this
     */
    public function setHasIcon($has_icon)
    {
        $this->has_icon = $has_icon;
        return $this;
    }



    public function showTableCell($item){

        $value = null;
        if(!$this->hide_index && !empty($item->{$this->name}) ) {

            //ha üres a relation
            if(!$this->belongsto_relation){
                throw new Exception("Empty relation. ".$this->getName(). ' nél add meg a setBelongstoRelation-t');
            }

            //ha nincs ilyen relation method-ja error
            if($item !== null && method_exists($item, $this->belongsto_relation) === FALSE && !$this->has_icon){
                throw new Exception("Not found relation : " . $this->belongsto_relation);
            }

            $icon = empty($item) ? null : $item->{$this->getBelongstoRelation()};


            $value = '<td class="'.$this->getIndexTdClass().'"><img src="'.$icon->getIconUrl('image').'"></td>';
        } else {
            $value ='<td></td>';
        }

        return $value;
    }
}