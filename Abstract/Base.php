<?php
abstract class DB_Pgsql_Type_Abstract_Base
{
    /**
     * Convert PHP variable to a native format.
     *
     * @param mixed $value
     * @return string
     */
    abstract public function output($value);
    
    /**
     * Parse a native value into PHP variable.
     * Throws exception if parsing process is finished
     * before the string is ended.
     *
     * @param string $native
     * @return mixed
     */
    abstract public function input($native);
}
