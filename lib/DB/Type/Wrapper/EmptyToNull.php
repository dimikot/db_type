<?php
class DB_Type_Wrapper_EmptyToNull extends DB_Type_Abstract_Wrapper
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
