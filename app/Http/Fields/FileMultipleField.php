<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 14:43
 */

namespace App\Http\Fields;

/**
 * Class FileMultipleField - Tömeges File feltöltés mező
 * @package App\Http\Fields
 */
class FileMultipleField extends FileField
{
    protected $type = 'file';
	protected $validation_rules = 'mimes:txt,doc,pdf'; // mime type ellenörzések
	protected $path ='file_dir'; // mezőnév ahová a fájlnak az elérését mentjük

    protected $blade_edit_location = 'common/fields/edit_elements/file_multiple';

    public function __construct($name) {
		parent::__construct($name);
		$this->attributes['multiple'] = true;
    }

    /**
	 * HTML Form-okhoz
	 * @param $item
	 *
     * @return \Illuminate\Http\Response
     */
    public function getFormHtml($item = null){

        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'item'))->render();
    }


}