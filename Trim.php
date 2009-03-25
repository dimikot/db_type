<?php
class DB_Pgsql_Type_Trim extends DB_Pgsql_Type_Abstract_Wrapper
{
    protected function _input($native)
    {
        return $native;
    }
    
    protected function _output($value)
    {
        return trim($value);
    }
}
