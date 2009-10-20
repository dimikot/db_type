<?php
class DB_Pgsql_Type_Test_Type_HstoreRowTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
	private function _getCommonTests()
	{
        return array(
            __LINE__ => array(
                new DB_Pgsql_Type_HstoreRow(array(
                    'b' => new DB_Pgsql_Type_String(),
                    'a' => new DB_Pgsql_Type_String(),
                )),
                array('b'=>"1", 'a'=>"2"),
                '"b"=>"1","a"=>"2"',
            ),
            __LINE__ => array(
                new DB_Pgsql_Type_HstoreRow(array(
                    'b' => new DB_Pgsql_Type_String(),
                    'a' => new DB_Pgsql_Type_String(),
                )),
                array('b'=>null, 'a'=>"zzz"),
                '"b"=>NULL,"a"=>"zzz"',
            ),
            __LINE__ => array(
                new DB_Pgsql_Type_HstoreRow(array(
                    'a' => new DB_Pgsql_Type_String(),
                    'b' => new DB_Pgsql_Type_String(),
                    'c' => new DB_Pgsql_Type_HstoreRow(array(
                        'd' => new DB_Pgsql_Type_String(),
                        'e' => new DB_Pgsql_Type_String(),
                    ))
                )),
                array('a'=>"1", 'b'=>"2", 'c'=>array('d'=>'d"d', 'e'=>"5")),
                '"a"=>"1","b"=>"2","c"=>"\"d\"=>\"d\\\\\\"d\\",\\"e\\"=>\\"5\\""',
            ),
            __LINE__ => array(
                new DB_Pgsql_Type_HstoreRow(array(
                    'a' => new DB_Pgsql_Type_String(),
                    'b' => new DB_Pgsql_Type_String(),
                    'c' => new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String())
                )),
                array('a'=>"1", 'b'=>"2", 'c'=>array("x", "y")),
                '"a"=>"1","b"=>"2","c"=>"{\"x\",\"y\"}"',
            ),
            __LINE__ => array(
                new DB_Pgsql_Type_HstoreRow(array(
                    'a' => new DB_Pgsql_Type_String(),
                    'c' => new DB_Pgsql_Type_HstoreRow(array(
                        'd' => new DB_Pgsql_Type_String(),
                    ))
                )),
                array('a'=>"aaa", 'c'=>null),
                '"a"=>"aaa","c"=>NULL',
            ),
            __LINE__ => array(
                new DB_Pgsql_Type_HstoreRow(array(
                    'b' => new DB_Pgsql_Type_String(),
                    'a' => new DB_Pgsql_Type_String(),
                )),
                null,
                null,
            ),
            __LINE__ => array(
                new DB_Pgsql_Type_HstoreRow(array()),
                "abcd",
                new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_HstoreRow(array()), "output", "PHP-array or null", "abcd"),
            ),
            __LINE__ => array(
                new DB_Pgsql_Type_HstoreRow(array("a" => new DB_Pgsql_Type_String())),
                new DB_Pgsql_Type_Exception_Common(
                    new DB_Pgsql_Type_HstoreRow(array("a" => new DB_Pgsql_Type_String())),
                    'input',
                    'UnexpectedKey',
                    's'
                ),
                'a => "ss", s => NULLED'
            ),
            __LINE__ => array(
                new DB_Pgsql_Type_HstoreRow(array("a" => new DB_Pgsql_Type_String())),
                array("a" => "a\\b"),
                '"a"=>"a\\\\b"',
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
