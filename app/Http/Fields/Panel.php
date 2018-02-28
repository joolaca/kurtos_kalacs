<?php

namespace App\Http\Fields;

/**
 * Class Panel - Mező sor konténer osztály
 * @package App\Http\Fields
 */
class Panel
{

    protected $name = ''; //field id-ja és name-je
    protected $title = ''; //field-hez tartozo label szovege
    protected $id = ''; //field típusa
    protected $class = ''; //laravel validalo szabalyok
    protected $permission = ''; // ha valamilyen különleges classt beállítanak

	protected static $_rowCountForAutoname = 0;


    /**
     * Panel-hez tartozó row-k
     *
     * @var array
     */
    protected $rows = array();

    public function __construct($name)
    {
		if(!empty($name)) {
			$this->name = $name;

		} else {
			$this->name = Panel::$_rowCountForAutoname++;
		}

		$this->id = $this->name;
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

    public function getTitle()
    {
		return $this->title;
    }

    public function getClass(){
        return $this->class;
    }

    public function getPermission(){
        return $this->permission;
    }

    public function getRows(){
        return $this->rows;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
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

	public function hasTitle() {
		return !empty($this->title);
	}

	public function hasRows() {
		return !empty($this->rows);
	}

    public function removeAllRows()
    {
        $this->rows = [];
		Panel::$_rowCountForAutoname = 0;

        return $this;
    }

    public function addRow($row)
    {
        $this->rows[$row->getName()] = $row;
		Panel::$_rowCountForAutoname++;
        return $this;
    }

    public function addRowBefore($rowName, $newRow)
    {

		$result = false;

		if (!empty($this->rows)) {
			$new = array();

			foreach ($this->rows as $row) {

				if ($row->getName() === $rowName) {
					$new[] = $newRow;
					$result = true;
				}
				$new[] = $row;
			}
			$this->rows = $new;
		} else {
			$this->rows[] = $newRow;
		}

        if($result) {
			Panel::$_rowCountForAutoname++;
		}
        return $this;
    }

    public function addFieldToRow($rowName, $field)
    {
		if(isset($this->rows[$rowName])) {
			$this->rows[$rowName]->addField($field);
		}

        return $this;
    }

    public function removeRowByName($rowName)
    {
		if(isset($this->rows[$rowName])) {
			unset($this->rows[$rowName]);
		}

        return $this;
    }

    public function removeFieldFromRow($rowName, $fieldName)
    {
		if(isset($this->rows[$rowName])) {
			$this->rows[$rowName]->deleteFieldByName($fieldName);
		}

        return $this;
    }

}