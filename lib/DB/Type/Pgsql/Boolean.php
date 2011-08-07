<?php
class DB_Type_Pgsql_Boolean extends DB_Type_Abstract_Primitive 
{
	public function output($value)
	{
        if ($value === null) {
            return null;
        }
		return !$value || $value === "false" || $value === "f"? 'f' : 't';
	}

    public function input($native)
    {
    	if ($native === null) {
    		return null;
    	}
    	$native = strval($native);
        return $native === 'false' || $native === 'f' || $native === '0' || $native === ''? false : true;
    }
	
    public function getNativeType()
    {
    	return 'BOOLEAN';
    }
}