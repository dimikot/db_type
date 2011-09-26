<?php
class DB_Type_Test_Wrapper_RangeTest extends DB_Type_Test_Util_TypeTestCase
{
	protected function _getPairsOutput()
	{
		$wrapperToTest = new DB_Type_Wrapper_Range(
			new DB_Type_Pgsql_Row(array(
				'other_before' => new DB_Type_String(),
				'value_from' => new DB_Type_Int(),
				'value_to' => new DB_Type_Int(),
				'other_after' => new DB_Type_String()
			))
		);

		$wrapperToTest_date = new DB_Type_Wrapper_Range(
			new DB_Type_Pgsql_Row(array(
				'date_from'   => new DB_Type_Date(),
				'date_to'     => new DB_Type_Date(),
			)),
			'date_from', 'date_to'
		);

		return array(
			array(
				$wrapperToTest,
				array('value_from' => 10, 'value_to' => 0),
				new DB_Type_Exception_Range($wrapperToTest,	10, 0),
				null,
			),
			array(
				$wrapperToTest,
				array('value_from' => 10, 'value_to' => 20),
				'(,"10","20",)',
				null,
			),
			array(
				$wrapperToTest_date,
				array('date_from' => '2005-05-15', 'date_to' => '2005-05-10'),
				new DB_Type_Exception_Range($wrapperToTest_date, '2005-05-15', '2005-05-10'),
				null,
			),
			array(
				$wrapperToTest_date,
				array('date_from' => '2005-05-15', 'date_to' => '2005-05-25'),
				'("2005-05-15","2005-05-25")',
				null,
			),
			array(
				$wrapperToTest_date,
				array('date_from' => array('d.m.Y', '15.05.2005'),
					  'date_to'   => array('d.m.Y', '25.05.2005')),
				'("2005-05-15","2005-05-25")',
				null,
			),
		);
	}
}
