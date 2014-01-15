<?php
class DB_Type_String extends DB_Type_Abstract_Primitive
{
    private $_min;
    private $_max;

    public function __construct($max = null, $min = null)
    {
        $this->_max = $max;
        $this->_min = $min;
    }

    public function output($value)
    {
        if ($value === null) {
            return null;
        }

        $value = strval($value);

        if ($this->_max !== null && strlen($value) > $this->_max) {
            throw new DB_Type_Exception_Common($this, __FUNCTION__, 'String less than: ' . $this->_max, $value);
        }

        if ($this->_min !== null && strlen($value) < $this->_min) {
            throw new DB_Type_Exception_Common($this, __FUNCTION__, 'String more than: ' . $this->_max, $value);
        }

        return $value;
    }

    public function input($native)
    {
        if ($native === null) {
            return null;
        }
        return strval($native);
    }
    
    public function getNativeType()
    {
        return 'VARCHAR';
    }
}