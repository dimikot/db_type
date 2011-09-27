<?php
class DB_Type_Test_DateTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_Date(),
                null,
                null,
                'DATE',
            ),
            array(
                new DB_Type_Date(DB_Type_Date::TRUNC_DAY),
                "12-10-2",
                "2012-10-02",
                'DATE',
            ),
            array(
                new DB_Type_Date(DB_Type_Date::TRUNC_DAY),
                "75-10-2",
                "1975-10-02",
                'DATE',
            ),
            array(
                new DB_Type_Date(DB_Type_Date::TRUNC_MONTH),
                "12-10-2",
                "2012-10-01",
                'DATE',
            ),
            array(
                new DB_Type_Date(DB_Type_Date::TRUNC_YEAR),
                "12-10-2",
                "2012-01-01",
                'DATE',
            ),
            array(
                new DB_Type_Date(),
                "12",
                "2012-01-01",
                'DATE',
            ),
            array(
                new DB_Type_Date(),
                "12-11",
                "2012-11-01",
                'DATE',
            ),
			// date formatting tests
			array(
				new DB_Type_Date(),
				array('d.m.y', '01.11.12'),
				"2012-11-01",
				'DATE',
			),
			array(
				new DB_Type_Date(DB_Type_Date::TRUNC_DAY, 'd.m.y'),
				'01.11.12',
				"2012-11-01",
				'DATE',
			),
			// date formatting tests
			array(
                new DB_Type_Date(),
                "12aaa",
                new DB_Type_Exception_Date(new DB_Type_Date(), "12aaa"),
                'DATE',
            ),
        );
    }

	protected function _getPairsInput()
	{
		return array(
			// date formatting tests
			array(
				new DB_Type_Date(DB_Type_Date::TRUNC_DAY, 'd.m.Y'),
				"25.12.2012",
				"2012-12-25",
			),
			array(
				new DB_Type_Date(DB_Type_Date::TRUNC_DAY, 'd.m.y'),
				"25.12.11",
				"2011-12-25",
			),
			array(
				new DB_Type_Date(DB_Type_Date::TRUNC_DAY, 'm.y'),
				"12.11",
				"2011-12-01",
			),
			// date formatting tests
		);
	}
}
