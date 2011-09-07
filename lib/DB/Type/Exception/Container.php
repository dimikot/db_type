<?php

class DB_Type_Exception_Container extends Exception {
	private $_type;
	private $_func;
	private $itemName;
	private $itemErrorMessage;

	public function __construct(DB_Type_Abstract_Base $type, $func, $itemName, $itemErrorMessage)
	{
		parent::__construct(get_class($type) . "::" . $func . "() item `$itemName` failed with message: $itemErrorMessage");
		$this->_type = $type;
		$this->_func = $func;
		$this->itemName = $itemName;
		$this->itemErrorMessage = $itemErrorMessage;
	}

	public function getType()
	{
		return $this->_type;
	}
}
