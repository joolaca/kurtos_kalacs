<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 14:50
 */

namespace App\Http\Fields;

/**
 * Class IntegerField - Rejtett id field
 * @package App\Http\Fields
 *
 */
class IntegerField extends Field
{

    protected $type = 'integer';
    protected $hide_edit = TRUE;
    protected $min = '';
    protected $max = '';

    /* -----------------------------------------
     *  GET
     ------------------------------------------*/
    /**
	 * Field minimum értéke
	 *
     * @return string $min
     */
    public function getMin(){
        return $this->min;
    }

    /**
	 * Field maximum értéke
	 *
     * @return string $max
     */
    public function getMax(){
        return $this->max;
    }

    /* -----------------------------------------
     *  SET
     ------------------------------------------*/

    /**
	 * Field minimum értéke
	 *
     * @param string $min
     */
    public function setMin($min){
        $this->min = $min;
        return $this;
    }
    /**
	 * Field maximum értéke
	 *
     * @param string $max
     */
    public function setMax($max){
        $this->max = $max;
        return $this;
    }

    /**
	 * HTML Form-okhoz
	 * @param $item
	 *
     * @return null
     */
    public function getFormHtml($item = null)
    {
        //nincs edit nézete
        return null;
    }


}