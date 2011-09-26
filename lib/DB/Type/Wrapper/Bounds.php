<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nehxby
 * Date: 11.08.11
 * Time: 14:25
 * To change this template use File | Settings | File Templates.
 */

class DB_Type_Wrapper_Bounds extends DB_Type_Abstract_Wrapper
{
	private $_min;
	private $_max;

	public function __construct(DB_Type_Numeric $item = null, $keyFrom = null, $keyTo = null)
	{
		parent::__construct($item);
		$this->_max = $keyTo;
		$this->_min = $keyFrom;
	}

	protected function _input($native)
	{
		return $native;
	}

	protected function _output($value)
	{
		$value = floatval($value);
		if ($this->_max !== null && $value > $this->_max) {
			throw new DB_Type_Exception_Bounds($this, $value);
		}
		if ($this->_min !== null && $value < $this->_min) {
			throw new DB_Type_Exception_Bounds($this, $value);
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
