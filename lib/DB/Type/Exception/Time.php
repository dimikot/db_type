<?php
class DB_Type_Exception_Time extends DB_Type_Exception_Common
{
	public function __construct(DB_Type_Abstract_Base $type, $given)
	{
		parent::__construct($type, "output", "HH or HH:MM or H:MM or HH:MM:SS", $given, 0);
	}
}
