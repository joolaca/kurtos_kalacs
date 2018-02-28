<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 15:52
 */

namespace App\Http\Fields;

use App\Model\ContentType\ContentType;

/**
 * Class ContentTypeField - Tartalom típus választó modal field.
 * @package App\Http\Fields
 */
class ContentTypeField extends Field
{

    protected $type = "content_type";
    protected $content_type = "";
    protected $content_type_id = null;
    protected $button_label = "";

    protected $blade_edit_location = 'common/fields/edit_elements/content_type';
    protected $value = null;
    protected $hide_field = FALSE; //elrejtjuk ha alapértelmezetten nem kell látszódnia

    /**
	 * Tartalom típus azonosítója
	 *
     * @return string $content_type
     */
    public function getContentType()
    {
        return $this->content_type;
    }

    /**
	 * Tartalom típusa
	 *
     * @param string $content_type
	 * @return ContentTypeField $this
     */
    public function setContentType($content_type)
    {
        $this->content_type = $content_type;
        return $this;
    }

    /**
	 * Tartalom típus azonosítója
	 *
     * @return string $content_type_id
     */
    public function getContentTypeId()
    {
        return $this->content_type_id;
    }

    /**
	 * Tartalom típus azonosító
	 *
     * @param string $content_type_id
	 * @return ContentTypeField $this
     */
    public function setContentTypeId($content_type_id)
    {
        $this->content_type_id = $content_type_id;
        return $this;
    }

    /**
	 * Hozzáad/ kiválaszt gomb felirata
	 *
     * @return string $button_label
     */
    public function getButtonLabel()
    {
        return $this->button_label;
    }

    /**
	 * Hozzáad/ kiválaszt gomb felirata
	 *
     * @param string $button_label
	 * @return ContentTypeField $this
     */
    public function setButtonLabel($button_label)
    {
        $this->button_label = $button_label;
        return $this;
    }


    /**
	 * Mező értéke
	 *
     * @return string $value
     */
	public function getValue() {
		return $this->value;
	}

    /**
	 * Mező értéke
	 *
     * @param string $value
	 * @return ContentTypeField $this
     */
	public function setValue($value) {
		$this->value = $value;
        return $this;
	}

    /**
	 * Tartalom típus beállítása id alapján
	 *
     * @param string $content_type_id
	 * @return ContentTypeField $this
     */
    public function setContentTypeById($content_type_id)
    {

        $content_type = ContentType::find($content_type_id);

        $this->setContentType(str_plural($content_type->name));
        $this->setContentTypeId($content_type->id);

        return $this;
    }

    /**
	 * HTML Form-okhoz
	 * @param $item
	 *
     * @return \Illuminate\Http\Response
     */
    public function getFormHtml($item = null){

        $content_type_item = null;

        $value = $this->getItemValue($item);

        if($value){

            $content_type = ContentType::find($this->getContentTypeId());

            $content_type_item = (new $content_type->model)->find($value);

        }

        $field = $this;

        return view($this->getBladeEditLocation() , compact('field', 'value', 'content_type_item'))->render();

    }
}