<?php
class DB_Type_Pgsql_Test_HstoreRowTest extends DB_Type_Test_Util_TypeTestCase
{
	private function _getCommonTests()
	{
        return array(
            __LINE__ => array(
                new DB_Type_Pgsql_HstoreRow(array(
                    'b' => new DB_Type_String(),
                    'a' => new DB_Type_String(),
                )),
                array('b'=>"1", 'a'=>"2"),
                '"b"=>"1","a"=>"2"',
                "hstore",
            ),
            __LINE__ => array(
                new DB_Type_Pgsql_HstoreRow(array(
                    'b' => new DB_Type_String(),
                    'a' => new DB_Type_String(),
                )),
                array('b'=>null, 'a'=>"zzz"),
                '"b"=>NULL,"a"=>"zzz"',
                "hstore",
            ),
            __LINE__ => array(
                new DB_Type_Pgsql_HstoreRow(array(
                    'a' => new DB_Type_String(),
                    'b' => new DB_Type_String(),
                    'c' => new DB_Type_Pgsql_HstoreRow(array(
                        'd' => new DB_Type_String(),
                        'e' => new DB_Type_String(),
                    ))
                )),
                array('a'=>"1", 'b'=>"2", 'c'=>array('d'=>'d"d', 'e'=>"5")),
                '"a"=>"1","b"=>"2","c"=>"\"d\"=>\"d\\\\\\"d\\",\\"e\\"=>\\"5\\""',
                "hstore",
            ),
            __LINE__ => array(
                new DB_Type_Pgsql_HstoreRow(array(
                    'a' => new DB_Type_String(),
                    'b' => new DB_Type_String(),
                    'c' => new DB_Type_Pgsql_Array(new DB_Type_String())
                )),
                array('a'=>"1", 'b'=>"2", 'c'=>array("x", "y")),
                '"a"=>"1","b"=>"2","c"=>"{\"x\",\"y\"}"',
                "hstore",
            ),
            __LINE__ => array(
                new DB_Type_Pgsql_HstoreRow(array(
                    'a' => new DB_Type_String(),
                    'c' => new DB_Type_Pgsql_HstoreRow(array(
                        'd' => new DB_Type_String(),
                    ))
                )),
                array('a'=>"aaa", 'c'=>null),
                '"a"=>"aaa","c"=>NULL',
                "hstore",
            ),
            __LINE__ => array(
                new DB_Type_Pgsql_HstoreRow(array(
                    'b' => new DB_Type_String(),
                    'a' => new DB_Type_String(),
                )),
                null,
                null,
                "hstore",
            ),
            __LINE__ => array(
                new DB_Type_Pgsql_HstoreRow(array()),
                "abcd",
                new DB_Type_Exception_Common(new DB_Type_Pgsql_HstoreRow(array()), "output", "PHP-array or null", "abcd"),
                "hstore",
            ),
            /*__LINE__ => array(
                new DB_Type_Pgsql_HstoreRow(array("a" => new DB_Type_String())),
                new DB_Type_Exception_Common(
                    new DB_Type_Pgsql_HstoreRow(array("a" => new DB_Type_String())),
                    'input',
                    'unexpected key',
                    's'
                ),
                'a => "ss", s => NULLED',
                "hstore",
            ),*/
            __LINE__ => array(
                new DB_Type_Pgsql_HstoreRow(array("a" => new DB_Type_String())),
                array("a" => "a\\b"),
                '"a"=>"a\\\\b"',
                "hstore",
            ),
        );
	}

    protected function _getPairsOutput()
    {
	    return $this->_getCommonTests();
    }

    protected function _getPairsInput()
    {
        return $this->_getCommonTests();
    }
}
