<?php
class DB_Type_Exception_Common extends Exception
{
	private $_type;
	private $_func;
	private $_expected;
	private $_given;
	private $_posGiven;

	public function __construct(DB_Type_Abstract_Base $type, $func, $expected, $given, $posGiven = 0)
	{
		parent::__construct(get_class($type) . "::" . $func . "() conversion error: given " . ($posGiven? "at position $posGiven " . substr_replace($given, ">>HERE>>", $posGiven, 0) : print_r($given, 1)) . ", expected $expected");
		$this->_type = $type;
		$this->_func = $func;
		$this->_expected = $expected;
		$this->_given = $given;
		$this->_posGiven = $posGiven;
	}

	public function getType()
	{
		return $this->_type;
	}
}
