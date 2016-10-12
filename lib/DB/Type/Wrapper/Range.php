<?php
class DB_Type_Wrapper_Range extends DB_Type_Abstract_Wrapper
{
	private $_keyFrom;
	private $_keyTo;

	public function __construct(DB_Type_Pgsql_Row $item = NULL, $min = 'value_from', $max = 'value_to')
	{
		parent::__construct($item);
		$this->_keyTo = $max;
		$this->_keyFrom = $min;
	}

	protected function _input($native)
	{
		return $native;
	}

	protected function _output($value)
	{
		if (is_object($value)) $value = (array)$value;

		if (is_array($value)) {
			$valueFrom = array_key_exists($this->_keyFrom, $value) ? $value[$this->_keyFrom] : NULL;
			$valueTo = array_key_exists($this->_keyTo, $value) ? $value[$this->_keyTo] : NULL;

			$row_items = $this->_item->getItems();

			if (is_array($valueFrom)) {
				if ($row_items[$this->_keyFrom]->getNativeType() == 'DATE') {
					$valueFrom = DB_Type_Date::extractDate($valueFrom);
					$valueFrom = $valueFrom->format('Y-m-d');
				} else return $value;
			}

			if (is_array($valueTo)) {
				if ($row_items[$this->_keyTo]->getNativeType() == 'DATE') {
					$valueTo = DB_Type_Date::extractDate($valueTo);
					$valueTo = $valueTo->format('Y-m-d');
				} else return $value;
			}

			if ($valueFrom && $valueTo && $valueFrom > $valueTo) {
				throw new DB_Type_Exception_Range($this, $valueFrom, $valueTo);
			}

			$value[$this->_keyFrom] = $valueFrom;
			$value[$this->_keyTo] = $valueTo;
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
