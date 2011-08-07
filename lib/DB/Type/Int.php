<?php
class DB_Type_Int extends DB_Type_Numeric
{
	public function output($value)
	{
		if ($value === null) {
			return null;
		}
		if (!is_numeric($value)) {
			throw new DB_Type_Exception_Int($this, $value);
		}
		if (
            intval($value) > 2147483647 || intval($value) < -2147483648 // 64 bits systems..
            || floatval($value) > 2147483647 || floatval($value) < -2147483648
		) {
            throw new DB_Type_Exception_Int($this, $value);
		}
		return $value;
	}

	public function input($value)
	{
		return $value;
	}
	
    public function getNativeType()
    {
    	return 'INT';
    }	
}