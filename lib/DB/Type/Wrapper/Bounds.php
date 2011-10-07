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

	public function __construct(DB_Type_Abstract_Base $item = null, $min = null, $max = null)
	{
		parent::__construct($item);
		$this->_min = $min;
		$this->_max = $max;
	}

	protected function _input($native)
	{
		return $native;
	}

	protected function _output($value)
	{
		$_value = floatval($value);
		if ($this->_max !== null && $_value > $this->_max) {
			throw new DB_Type_Exception_Bounds($this, $value);
		}
		if ($this->_min !== null && $_value < $this->_min) {
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
