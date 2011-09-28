<?php
class DB_Type_Pgsql_Test_HstoreTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
		return array(
            array(
                new DB_Type_Pgsql_Hstore(new DB_Type_String()),
                array('a' => 'xx', 'b' => 'yy'),
	            '"a"=>"xx","b"=>"yy"',
                "hstore",
	        ),
	        array(
                new DB_Type_Pgsql_Hstore(new DB_Type_String()),
	            array('aaa"=>' => 'xx', 'b' => 'yy'),
	            '"aaa\"=>"=>"xx","b"=>"yy"',
	            "hstore",
	        ),
	        array(
                new DB_Type_Pgsql_Hstore(new DB_Type_String()),
	            array('a"aa"' => 'xx', 'b' => 'yy'),
	            '"a\"aa\""=>"xx","b"=>"yy"',
	            "hstore",
	        ),
	        array(
                new DB_Type_Pgsql_Hstore(new DB_Type_String()),
	            array('a"aa"' => 'xx', 'b' => 'y"y'),
	            '"a\"aa\""=>"xx","b"=>"y\"y"',
	            "hstore",
	        ),
	        array(
                new DB_Type_Pgsql_Hstore(new DB_Type_String()),
	            array(),
	            '',
	            "hstore",
	        ),
	        array(
                new DB_Type_Pgsql_Hstore(new DB_Type_String()),
	            null,
	            null,
	            "hstore",
	        ),
            array(
                new DB_Type_Pgsql_Hstore(new DB_Type_String()),
                "aaa",
                new DB_Type_Exception_Common(new DB_Type_Pgsql_Hstore(new DB_Type_String()), "output", "PHP-array or null", 'aaa'),
                "hstore",
            ),
			array(
				new DB_Type_Pgsql_Hstore(new DB_Type_Int()),
				array('a' => '5', 'b' => 'not_int'),
				new DB_Type_Exception_Container(new DB_Type_Pgsql_Hstore(new DB_Type_Int()), 'output', 'b', 'DB_Type_Int::output() conversion error: given not_int, expected int32 value'),
				"hstore",
			),
		);
    }

    protected function _getPairsInput()
    {
        return array_merge(
            $this->_getPairsOutput(),
            array(
	            array(
	                new DB_Type_Pgsql_Hstore(new DB_Type_String()),
	                new DB_Type_Exception_Common(new DB_Type_Pgsql_Hstore(new DB_Type_String()), "input", "'=>'", 'aaa bbb', 4),
                    "aaa bbb",
	            ),
                array(
                    new DB_Type_Pgsql_Hstore(new DB_Type_String()),
                    array("aaa" => null),
                    "aaa => NULL",
                ),
                array(
                    new DB_Type_Pgsql_Hstore(new DB_Type_String()),
                    new DB_Type_Exception_Common(new DB_Type_Pgsql_Hstore(new DB_Type_String()), "input", "quoted or unquoted string", '"aaa', 0),
                    '"aaa',
                ),
				// test for itemsInput
				array(
					new DB_Type_Pgsql_Hstore(
						new DB_Type_Pgsql_Hstore(new DB_Type_String())
					),
					array('bbb' => array("aaa" => null)),
					array("bbb" => "aaa => NULL"),
				),
				// test for itemsInput
			)
        );
    }
}
