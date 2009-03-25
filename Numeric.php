<?php
class DB_Pgsql_Type_Numeric extends DB_Pgsql_Type_Abstract_Primitive  
{
	public function output($value)
	{
		if ($value === null) {
			return null;
		}
		if (!is_numeric($value)) {
			throw new DB_Pgsql_Type_Exception_Numeric($this, $value);
		}
		return $value;
	}
	
	public function input($value)
	{
        if ($value === null) {
            return null;
        }
		return $value;
	}
}