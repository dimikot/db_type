<?php
class DB_Pgsql_Type_Exception_Int extends DB_Pgsql_Type_Exception_Common
{
	public function __construct(DB_Pgsql_Type_Abstract_Base $type, $given)
	{
		parent::__construct($type, "output", "int32 value", $given, 0);
	}
}
