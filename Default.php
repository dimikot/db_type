<?php
class DB_Pgsql_Type_Default extends DB_Pgsql_Type_Abstract_Primitive
{
    private $_inputType;
    private $_value;

    public function __construct(DB_Pgsql_Type_Abstract_Base $item, $value)
    {
        $this->_inputType = $item;
        $this->_value = $item->output($value);
    }

    public function output($value)
    {
        if ($value === null) {
            return $this->_value;
        } else {
            return $this->_inputType->output($value);
        }
    }

    public function input($native)
    {
        return $this->_inputType->input($native);
    }
}