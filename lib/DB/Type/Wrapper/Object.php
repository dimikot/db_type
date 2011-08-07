<?php
class DB_Type_Wrapper_Object extends DB_Type_Abstract_Wrapper
{
    protected function _input($native)
    {
        return is_array($native) ? (object) $native : $native;
    }

    protected function _output($value)
    {
        return $value;
    }
}