<?php
class DB_Type_Wrapper_Range extends DB_Type_Abstract_Wrapper
{
	private $_keyFrom;
	private $_keyTo;

	public function __construct(DB_Type_Pgsql_Row $item = null, $keyFrom = 'value_from', $keyTo = 'value_to')
	{
		parent::__construct($item);
		$this->_keyTo = $keyTo;
		$this->_keyFrom = $keyFrom;
	}

	protected function _input($native)
	{
		return $native;
	}

	protected function _output($value)
	{
		if ( is_object($value) ) $value = (array) $value;

		if (is_array($value)) {
			$valueFrom = key_exists($this->_keyFrom, $value)? $value[$this->_keyFrom]: null;
			$valueTo = key_exists($this->_keyTo, $value) ? $value[$this->_keyTo] : null;

			if ($valueFrom > $valueTo) {
				throw new DB_Type_Exception_Range($this, $valueFrom, $valueTo);
			}
		}

		return $value;
	}

	public function getKeyFrom()
	{
		return $this->_keyFrom;
	}

	public function getKeyTo()
	{
		return $this->_keyTo;
	}
}
