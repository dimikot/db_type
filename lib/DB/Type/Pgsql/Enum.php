<?php

class DB_Type_Pgsql_Enum extends DB_Type_Abstract_Primitive {

	private $_items;

	function __construct(array $items)
	{
		$this->_items = $items;
		//reset($this->_items);
	}

	public function getItems()
	{
		return $this->_items;
	}

	private function checkValue($value)
	{
		if ($value && !in_array($value, $this->_items))
			throw new DB_Type_Exception_Enum($this, $value);
	}

	/**
	 * Convert PHP variable to a native format.
	 *
	 * @param mixed $value
	 * @return string
	 */
	public function output($value)
	{
		$this->checkValue($value);
		return $value;
	}

	/**
	 * Parse a native value into PHP variable.
	 * Throws exception if parsing process is finished
	 * before the string is ended.
	 *
	 * @param string $native
	 * @return mixed
	 */
	public function input($native)
	{
		$this->checkValue($native);
		return $native;
	}

	/**
	 * Return native type name for this value.
	 *
	 * @return string
	 */
	public function getNativeType()
	{
		return 'ENUM';
	}

	public function getEmpty()
	{
		return current($this->_items);
	}
}
