<?php
class DB_Type_Exception_Date extends DB_Type_Exception_Common
{
	public function __construct(DB_Type_Abstract_Base $type, $given)
	{
		parent::__construct($type, "output", "YY (or YYYY) or YY-MM or YY-MM-DD", $given, 0);
	}
}
