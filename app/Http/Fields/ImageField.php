<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 14:43
 */

namespace App\Http\Fields;
use Illuminate\Support\Facades\Route;

/**
 * Class ImageField - Kép feltöltés mező
 * @package App\Http\Fields
 */
class ImageField extends FileField
{
    protected $type = 'image';
	protected $validation_rules = 'image|mimes:jpg,jpeg,png,gif'; // mime type ellenörzések
    protected $path ='file_dir'; // mezőnév ahová a fájlnak az elérését mentjük

    protected $blade_edit_location = 'common/fields/edit_elements/image';

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
		if(!$this->hide_index && !empty($item->{$this->name}) ) {
			$value = '<td class="'.$this->getIndexTdClass().'"><img class="ctud_table_img" src="'.$item->adminIndexImageUrl($this->name).'" alt=""></td>';
		} else {
			$value ='<td></td>';
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

        $controller = Route::getCurrentRoute()->getController();

        //megvizsgáljuk, hogy a modellünk thumbnailable-e
        if(array_key_exists('model_class', $controller->crud_data)){
            $base_model = $controller->crud_data['model_class'];
            $base_model = new $base_model;

            $base_model->thumbnail_col_name;

            $thumbnailable = $base_model->thumbnail_col_name ? TRUE : FALSE;

        }else{

            $thumbnailable = FALSE;

        }

        //ha van megadva kép, akkor letiltjuk
        //hogy mert más paraméterek módosításánál a képet ne kelljen beállítani
        if($item && $item->{$this->getName()}) {
            $this->setAttributes([
                'disabled' => true
            ]);
        }

        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'item', 'thumbnailable'))->render();
    }

    /**
	 * HTML Listanézethez fájlelérési útvonal
	 *
     * @return string $path
     */
    public function getPathCol(){
        return $this->path;
    }
}