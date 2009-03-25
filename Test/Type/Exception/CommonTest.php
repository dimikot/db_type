<?php
class DB_Pgsql_Type_Test_Type_Exception_CommonTest extends PHPUnit_Framework_TestCase
{
	private $_t;
	private $_e;
	
	public function setUp()
	{
		$this->_t = new DB_Pgsql_Type_String();
		$this->_e = new DB_Pgsql_Type_Exception_Common($this->_t, 'input', 'aaaa', 'bbb', 1);
	}
	
	public function testGetType()
	{
		$this->assertSame($this->_e->getType(), $this->_t);
	}
}
