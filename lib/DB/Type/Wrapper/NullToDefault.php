<?php
class DB_Type_Wrapper_NullToDefault extends DB_Type_Abstract_Base
{
	// We cannot inherit from DB_Type_Abstract_Wrapper, because it
	// treats NULL as NULL and does not call abstract _output()
	// in this case.
	private $_value;
	private $_item;

	public function __construct($value, DB_Type_Abstract_Base $item = null)
	{
		$this->_item = $item? $item : new DB_Type_String();
		$this->_value = $value;
	}

	public function output($value)
	{
		if ($value === null) {
			$value = $this->_value;
		}
        return $this->_item->output($value);
	}

	public function input($native, $for='')
	{
		return $this->_item->input($native, $for='');
	}

	public function getNativeType()
	{
		return $this->_item->getNativeType();
	}
}
