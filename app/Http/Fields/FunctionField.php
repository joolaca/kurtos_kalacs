<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 15:52
 */

namespace App\Http\Fields;

/**
 * Class HiddenField - Hidden mező
 * @package App\Http\Fields
 */
class FunctionField extends Field
{

    protected $type = "function";
    protected $hide_edit = TRUE;
    protected $blade_edit_location = '';//nincs view-ja

    /**
     * Index oldalon a tablazat fejleceben megjeleno szoveg
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
        $value = null;
        if(!$this->hide_index) {

            if (method_exists($item, $this->name)) { // Sima fügvény hívás
                return '<td class="'.$this->getIndexTdClass().'">' . strip_tags($item->{$this->name}()) . '</td>';
            } else {
                $value = '<td></td>';
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

		return null;

    }
}