<?php
class DB_Pgsql_Type_Length extends DB_Pgsql_Type_Abstract_Wrapper
{
    private $_min;
    private $_max;

    public function __construct(DB_Pgsql_Type_Abstract_Base $item = null, $min = null, $max = null)
    {
        parent::__construct($item);
        $this->_max = $max;
        $this->_min = $min;
    }

    protected function _input($native)
    {
    	return $native;
    }
    
    protected function _output($value)
    {
        if ($this->_max !== null && strlen($value) > $this->_max) {
            throw new DB_Pgsql_Type_Exception_Length($this, $value);
        }
        if ($this->_min !== null && strlen($value) < $this->_min) {
            throw new DB_Pgsql_Type_Exception_Length($this, $value);
        }
        return $value;
    }
    
    public function getMin()
    {
    	return $this->_min;
    }

    public function getMax()
    {
        return $this->_max;
    }
}
