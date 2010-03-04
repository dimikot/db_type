<?php
class DB_Pgsql_Type_StringInterval extends DB_Pgsql_Type_Abstract_Primitive
{

    public function output($value)
    {
        if ($value === null) {
            return null;
        }

        if (strtotime($value) === false) {
            throw new DB_Pgsql_Type_Exception_Common($this, __FUNCTION__, 'This is not a string interval', $value);
        }

        return $value;
    }

    public function input($native)
    {
        return $native;
    }
}