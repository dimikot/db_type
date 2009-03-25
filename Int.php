<?php
class DB_Pgsql_Type_Int extends DB_Pgsql_Type_Numeric 
{
	public function output($value)
	{
		if ($value === null) {
			return null;
		}
		if (!is_numeric($value)) {
			throw new DB_Pgsql_Type_Exception_Int($this, $value);
		}
		if (
            intval($value) === intval('999999999999999999999999999999999999999999999')
            || intval($value) === intval('-999999999999999999999999999999999999999999999')
		) {
            throw new DB_Pgsql_Type_Exception_Int($this, $value);
		}
		return $value;
	}
	
	public function input($value)
	{
		return $value;
	}
}