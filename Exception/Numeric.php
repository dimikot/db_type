<?php
class DB_Pgsql_Type_Exception_Numeric extends DB_Pgsql_Type_Exception_Common
{
	public function __construct(DB_Pgsql_Type_Abstract_Base $type, $given)
	{
		parent::__construct($type, "output", "numeric value", $given, 0);
	}
}
