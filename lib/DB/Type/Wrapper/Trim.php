<?php
class DB_Type_Wrapper_Trim extends DB_Type_Abstract_Wrapper
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
