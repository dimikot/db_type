<?php
class DB_Pgsql_Type_Object extends DB_Pgsql_Type_Abstract_Wrapper
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