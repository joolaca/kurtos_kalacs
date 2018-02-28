<?php

namespace App\Http\Fields;

/**
 * Class Row - Mező konténer osztály
 * @package App\Http\Fields
 */
class Row
{

    protected $name = ''; //row id-ja és name-je
    protected $id = ''; //field típusa
    protected $class = ''; //laravel validalo szabalyok
    protected $permission = ''; // ha valamilyen különleges classt beállítanak
	protected $isHidden = false; //Form-okon ha csak hidden fierld van a sorban, akkor máshogy kell renderelni

    /**
     * Panel-hez tartozó field-ek
     *
     * @var array
     */
    protected $fields = array();

    public function __construct($name)
    {
        $this->name = $name;
		$this->id = $name;
    }



    /* -----------------------------------------
     *  GETek SETek
     ------------------------------------------*/

    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
		return $this->id;
    }

    public function getClass(){
        return $this->class;
    }

    public function getPermission(){
        return $this->permission;
    }

    public function isHidden(){
        return $this->isHidden;
    }

    public function getFields(){
        return $this->fields;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    public function setPermission($permission)
    {
        $this->permission = $permission;
        return $this;
    }

    public function setIsHidden($isHidden)
    {
        $this->isHidden = $isHidden;
        return $this;
    }

	public function hasFields() {
		return !empty($this->fields);
	}

    public function addField($field)
    {
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    public function addFieldBefore($fieldName, $newField)
    {

		$result = false;

		if (!empty($this->fields)) {
			$new = array();

			foreach ($this->fields as $field) {

				if ($field->getName() === $fieldName) {
					$new[] = $newField;
					$result = true;
				}
				$new[] = $field;
			}
			$this->fields = $new;
		} else {
			$this->fields[] = $newField;
		}

        return $this;
    }


    public function deleteFieldByName($fieldName)
    {
		if(isset($this->fields[$fieldName])) {
			unset($this->fields[$fieldName]);
		}
        return $this;
    }

}