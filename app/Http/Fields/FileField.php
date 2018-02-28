<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 14:43
 */

namespace App\Http\Fields;

/**
 * Class FileField - File feltöltés mező
 * @package App\Http\Fields
 */
class FileField extends Field
{
    protected $type = 'file';
	protected $validation_rules = 'mimes:txt,txt,csv,pdf,jpg,jpeg,png,ppt,pptx,xls,xlsx,mp4,webm,ogg,avi,wmv,zip,doc,docx'; // mime type ellenörzések
	protected $path ='file_dir'; // mezőnév ahová a fájlnak az elérését mentjük

    protected $blade_edit_location = 'common/fields/edit_elements/file';

    public function __construct($name) {
		parent::__construct($name);
    }

    /**
	 * Fájl elérési útvonal
	 *
     * @return string $path
     */
    public function getPath(){
        return $this->path;
    }
    /**
	 * Fájl elérési útvonal
	 *
     * @param string $path
     */
    public function setPath($path){
        $this->path = $path;
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
		$value = null;
		if(!$this->hide_index && !empty($item->{$this->name}) ) {
			$value = '<td class="'.$this->getIndexTdClass().'"><a href="'.$item->getFileUrl($this->name).'" target_blank>'.$item->getFilePath($this->name).'</a></td>';
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

        //ha van megadva dokumentum, akkor letiltjuk
        //hogy mert más paraméterek módosításánál a dokumentumot ne kelljen beállítani
        if($item && $item->{$this->getName()}) {
            $this->setAttributes([
                'disabled' => true
            ]);
        }

        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'item'))->render();
    }


}