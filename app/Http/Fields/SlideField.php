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
 * Class SlideField - Kép kiválasztó mező
 * @package App\Http\Fields
 */
class SlideField extends Field
{
    protected $type = 'slide';

    protected $blade_edit_location = 'common/fields/edit_elements/slide';

    protected $hide_index = TRUE;

    protected $belongsto_relation = '';

    protected $validation_rules = 'nullable|integer';

    protected $slide;

    protected $has_slide = false;

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
        if($item !== null && method_exists($item, $this->belongsto_relation) === FALSE && !$this->has_slide){
            throw new Exception("Not found relation : " . $this->belongsto_relation);
        }

        $value = $this->getItemValue($item);
        $slide = empty($item) ? null : $item->{$this->getBelongstoRelation()};
        //ha üres a slide, megnézzük a slide mezőt is, mert lehet a moduloknál egy modultípus mezőjéről van szó,
        // az pedig értéket csak a slider paraméter alapján tudja átadni.
        if(empty($slide))
            {
                $slide = $this->getSlide();
            }

        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'item', 'value', 'slide'))->render();
    }


    /**
     * @return mixed
     */
    public function getSlide()
    {
        return $this->slide;
    }


    /**
     * @param $slide
     *
     * @return $this
     */
    public function setSlide($slide)
    {
        $this->slide = $slide;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getHasSlide()
    {
        return $this->has_slide;
    }


    /**
     * @param $slide
     *
     * @return $this
     */
    public function setHasSlide($has_slide)
    {
        $this->has_slide = $has_slide;
        return $this;
    }



    public function showTableCell($item){
    {

        $value = null;
        if(!$this->hide_index && !empty($item->{$this->name}) ) {

            //ha üres a relation
            if(!$this->belongsto_relation){
                throw new Exception("Empty relation. ".$this->getName(). ' nél add meg a setBelongstoRelation-t');
            }

            //ha nincs ilyen relation method-ja error
            if($item !== null && method_exists($item, $this->belongsto_relation) === FALSE && !$this->has_slide){
                throw new Exception("Not found relation : " . $this->belongsto_relation);
            }

            $slide = empty($item) ? null : $item->{$this->getBelongstoRelation()};


            $value = '<td class="'.$this->getIndexTdClass().'"><img src="'.$slide->getImageThumbUrl('image').'"></td>';
        } else {
            $value ='<td></td>';
        }

        return $value;
    }
    }
}