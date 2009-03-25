<?php
class DB_Pgsql_Type_Constant extends DB_Pgsql_Type_Abstract_Primitive
{
	private $_value;
	
	public function __construct($value, DB_Pgsql_Type_Abstract_Base $item = null)
	{
		$this->_value = $value === null? $value : strval($value);
		if ($item) {
			$this->_value = $item->output($value);
		}
	}
	
	public function output($value)
	{
		$value;
        return $this->_value;
	}
	
	public function input($native)
	{
		return $native;
	}
}