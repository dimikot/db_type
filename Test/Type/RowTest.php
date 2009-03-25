<?php
class DB_Pgsql_Type_Test_Type_RowTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
	private function _getCommonTests()
	{
        return array(
            array(
                new DB_Pgsql_Type_Row(array(
                    'b' => new DB_Pgsql_Type_String(),
                    'a' => new DB_Pgsql_Type_String(),
                )),
                array('b'=>"1", 'a'=>"2"),
                '("1","2")',
            ),
            array(
                new DB_Pgsql_Type_Row(array(
                    'b' => new DB_Pgsql_Type_String(),
                    'a' => new DB_Pgsql_Type_String(),
                )),
                array('b'=>null, 'a'=>"zzz"),
                '(,"zzz")',
            ),
            array(
                new DB_Pgsql_Type_Row(array(
                    'a' => new DB_Pgsql_Type_String(),
                    'b' => new DB_Pgsql_Type_String(),
                    'c' => new DB_Pgsql_Type_Row(array(
                        'd' => new DB_Pgsql_Type_String(),
                        'e' => new DB_Pgsql_Type_String(),
                    ))
                )),
                array('a'=>"1", 'b'=>"2", 'c'=>array('d'=>'d"d', 'e'=>"5")),
                '("1","2","(""d""""d"",""5"")")',
            ),
            array(
                new DB_Pgsql_Type_Row(array(
                    'a' => new DB_Pgsql_Type_String(),
                    'b' => new DB_Pgsql_Type_String(),
                    'c' => new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String())
                )),
                array('a'=>"1", 'b'=>"2", 'c'=>array("x", "y")),
                '("1","2","{""x"",""y""}")',
            ),
            array(
                new DB_Pgsql_Type_Row(array(
                    'a' => new DB_Pgsql_Type_String(),
                    'c' => new DB_Pgsql_Type_Row(array(
                        'd' => new DB_Pgsql_Type_String(),
                    ))
                )),
                array('a'=>"aaa", 'c'=>null),
                '("aaa",)',
            ),
            array(
                new DB_Pgsql_Type_Row(array(
                    'b' => new DB_Pgsql_Type_String(),
                    'a' => new DB_Pgsql_Type_String(),
                )),
                null,
                null,
            ),
            array(
                new DB_Pgsql_Type_Row(array()),
                "abcd",
                new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Row(array()), "output", "row or null", "abcd"),
            ),
            array(
                new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())),
                array(),
                new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())), "output", "value for field 'a'", '<NO_SUCH_KEY>'),
            ),
            array(
                new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())),
                array("a" => "a\\b"),
                '("a\\\\b")',
            ),
        );
	}
	
    protected function _getPairsOutput()
    {
	    return array_merge( 
            $this->_getCommonTests(),
            array(
	            'a' => array(
	                new DB_Pgsql_Type_Row(array(
	                    'b' => new DB_Pgsql_Type_String(),
	                    'a' => new DB_Pgsql_Type_EmptyNull(new DB_Pgsql_Type_String()),
	                )),
	                array('b'=>null, 'a'=>""),
	                '(,)',
	            ),
	        )
        );
    }

    protected function _getPairsInput()
    {
        return array_merge(
            $this->_getCommonTests(),
            array(
	            array(
	                new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())),
	                new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())), "input", "start of a row '('", 'xxx'),
                    'xxx',
	            ),
                array(
                    new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())),
                    new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())), "input", "field 'a' value", '()', 1),
                    '()',
                ),
                array(
                    new DB_Pgsql_Type_Row(array()),
                    array(),
                    '()',
                ),
                array(
                    new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())),
                    new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())), "input", "end of the row: no more fields left", '("aa", "bb")', 7),
                    '("aa", "bb")',
                ),
                array(
                    new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())),
                    array("a" => "aa"),
                    '("aa")',
                ),
                array(
                    new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())),
                    array("a" => "aa"),
                    '(aa)',
                ),
                array(
                    new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())),
                    new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())), "input", "balanced quoted or unquoted string", '("aa)', 1),
                    '("aa)',
                ),
                array(
                    new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())),
                    new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Row(array("a" => new DB_Pgsql_Type_String())), "input", "delimiter ',' or ')'", '(aa', 3),
                    '(aa',
                ),
    	        array(
                    new DB_Pgsql_Type_Row(array(
                        'b' => new DB_Pgsql_Type_String(),
                        'a' => new DB_Pgsql_Type_String(),
                    )),
    	            array('b'=>'ффф', 'a'=>"2"),
    	            '(ффф,"2")',
    	        ),
    	        array(
                    new DB_Pgsql_Type_Row(array(
                        'b' => new DB_Pgsql_Type_String(),
                        'a' => new DB_Pgsql_Type_String(),
                    )),
    	            array('b'=>"aaaaa aa", 'a'=>"2"),
    	            '("aaaaa aa","2")',
    	        ),
            )
        );
    }
}
