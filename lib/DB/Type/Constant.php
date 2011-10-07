<?php
class DB_Type_Constant extends DB_Type_Abstract_Primitive
{
	private $_value;
	private $_item;

	public function __construct($value, DB_Type_Abstract_Base $item = null)
	{
		$this->_item = $item;
		if ($item) {
			$this->_value = $item->output($value);
		} else {
			$this->_value = $value === null? $value : strval($value);
		}
	}

	public function output($value)
	{
		$value;
        return $this->_value;
	}

	public function input($native, $for = '')
	{
		return $native;
	}

    public function getNativeType()
    {
    	return $this->_item? $this->_item->getNativeType() : 'VARCHAR';
    }
}
