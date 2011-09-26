<?php
class DB_Type_Exception_Range extends DB_Type_Exception_Common
{
	public function __construct(DB_Type_Abstract_Base $type, $givenFrom, $givenTo)
	{
		parent::__construct($type, "output", "item `{$type->getKeyFrom()}` <= item `{$type->getKeyTo()}`", "$givenFrom > $givenTo", 0);
	}
}
