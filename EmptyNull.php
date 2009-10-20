<?php
class DB_Pgsql_Type_EmptyNull extends DB_Pgsql_Type_Abstract_Wrapper
{
    protected function _input($native)
    {
        return $native;
    }

    protected function _output($value)
    {
        return
            is_scalar($value)
                && strval($value) === ""
                && $value !== false
                && $value !== true
            ? null
            : $value;
    }
}
