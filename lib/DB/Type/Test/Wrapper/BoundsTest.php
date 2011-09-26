<?php
class DB_Type_Test_Wrapper_BoundsTest extends DB_Type_Test_Util_TypeTestCase
{
	protected function _getPairsOutput()
	{
		return array(
			array(
				new DB_Type_Wrapper_Bounds(new DB_Type_Int(), 20),
				10,
				new DB_Type_Exception_Bounds(
					new DB_Type_Wrapper_Bounds(new DB_Type_Int(), 20),
					10
				),
				'VARCHAR',
			),
			array(
				new DB_Type_Wrapper_Bounds(new DB_Type_Int(), 0, 2),
				5,
				new DB_Type_Exception_Bounds(
					new DB_Type_Wrapper_Bounds(new DB_Type_Int(), 0, 2),
					5
				),
				'VARCHAR',
			),
			array(
				new DB_Type_Wrapper_Bounds(new DB_Type_Numeric(3, 1), 10.5),
				15.5,
				'15.5',
				'NUMERIC',
			),
		);
	}
}
