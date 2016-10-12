<?php
class DB_Type_String extends DB_Type_Abstract_Primitive
{
    private $_min;
    private $_max;

    public function __construct($max = NULL, $min = NULL)
    {
        $this->_max = $max;
        $this->_min = $min;
    }

	public function output($value)
	{
        if ($value === NULL) {
            return NULL;
        }

		$value = strval($value);

		if ($this->_max !== NULL && mb_strlen($value, 'UTF-8') > $this->_max) {
            throw new DB_Type_Exception_Common($this, __FUNCTION__, 'String less than: ' . $this->_max, $value);
        }

        if ($this->_min !== NULL && mb_strlen($value, 'UTF-8') < $this->_min) {
            throw new DB_Type_Exception_Common($this, __FUNCTION__, 'String more than: ' . $this->_max, $value);
        }

        return $value;
	}

	public function input($native, $for='')
	{
        if ($native === NULL) {
            return NULL;
        }
		return strval($native);
	}

    public function getNativeType()
    {
    	return 'VARCHAR';
    }
}
