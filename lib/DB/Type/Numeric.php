<?php
class DB_Type_Numeric extends DB_Type_Abstract_Primitive
{
    private $_precision;
    private $_width;
    private $_skipArrayParseOptimization = false;

    public function __construct($width = null, $precision = null, $skipArrayParseOptimization = false)
    {
        $this->_width = $width;
        $this->_precision = $precision;
        $this->_skipArrayParseOptimization = $skipArrayParseOptimization;
    }

    public function output($value)
    {
        if ($value === null) {
            return null;
        }

        $value = str_replace(',', '.', $value);
        if (!is_numeric($value)) {
            throw new DB_Type_Exception_Numeric($this, $value);
        }

        if ($this->_width !== null || $this->_precision !== null) {
            $parts = explode('.', (string)$value);
            if (
                $this->_width !== null
                && isset($parts[0])
                && strlen($parts[0]) > $this->_width
            ) {
                throw new DB_Type_Exception_Numeric($this, $value);
            }

            if (
                $this->_precision !== null
                && isset($parts[1])
                && strlen($parts[1]) > $this->_precision
            ) {
                throw new DB_Type_Exception_Numeric($this, $value);
            }
        }

        return $value;
    }

    public function input($value)
    {
        if ($value === null) {
            return null;
        }
        return $value;
    }
    
    public function getNativeType()
    {
        return 'NUMERIC';
    }

    public function skipArrayParseOptimization()
    {
        return $this->_skipArrayParseOptimization;
    }
}
