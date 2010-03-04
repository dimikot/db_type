<?php
class DB_Pgsql_Type_ReadOnly extends DB_Pgsql_Type_Abstract_Primitive
{
	private $_inputType;
	private $_value;

	public function __construct($value, DB_Pgsql_Type_Abstract_Base $item = null)
	{
		if ($item) {
		    $this->_inputType = $item;
			$this->_value = $item->output($value);
		} else {
		    $this->_value = $value === null? $value : strval($value);
		}
	}

	public function output($value)
	{
	    $value;
        return $this->_value;
	}

	public function input($native)
	{
	    if ($this->_inputType instanceof DB_Pgsql_Type_Abstract_Base) {
	        return $this->_inputType->input($native);
	    }
		return $native;
	}
}