<?php
class DB_Pgsql_Type_Test_Type_HstoreTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()),
                array('a' => 'xx', 'b' => 'yy'),
	            '"a"=>"xx","b"=>"yy"',
	        ),
	        array(
                new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()),
	            array('aaa"=>' => 'xx', 'b' => 'yy'),
	            '"aaa\"=>"=>"xx","b"=>"yy"',
	        ),
	        array(
                new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()),
	            array('a"aa"' => 'xx', 'b' => 'yy'),
	            '"a\"aa\""=>"xx","b"=>"yy"',
	        ),
	        array(
                new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()),
	            array('a"aa"' => 'xx', 'b' => 'y"y'),
	            '"a\"aa\""=>"xx","b"=>"y\"y"',
	        ),
	        array(
                new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()),
	            array(),
	            '',
	        ),
	        array(
                new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()),
	            null,
	            null,
	        ),
            array(
                new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()),
                "aaa",
                new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()), "output", "PHP-array or null", 'aaa'),
            ),
	    );
    }

    protected function _getPairsInput()
    {
        return array_merge(
            $this->_getPairsOutput(),
            array(
	            array(
	                new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()),
	                new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()), "input", "'=>'", 'aaa bbb', 4),
                    "aaa bbb",
	            ),
                array(
                    new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()),
                    array("aaa" => null),
                    "aaa => NULL",
                ),	            
                array(
                    new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()),
                    new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_String()), "input", "quoted or unquoted string", '"aaa', 0),
                    '"aaa',
                ),	            
            )
        );
    }
}
