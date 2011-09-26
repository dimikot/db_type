<?php
class DB_Type_Pgsql_Test_RowTest extends DB_Type_Test_Util_TypeTestCase
{
	private function _getCommonTests()
	{
        return array(
            array(
                new DB_Type_Pgsql_Row(array(
                    'b' => new DB_Type_String(),
                    'a' => new DB_Type_String(),
                )),
                array('b'=>"1", 'a'=>"2"),
                '("1","2")',
                null,
            ),
            array(
                new DB_Type_Pgsql_Row(
                	array(
                    	'b' => new DB_Type_String(),
                    	'a' => new DB_Type_String(),
                	),
                	'some_table'
                ),
                array('b'=>"1", 'a'=>"2"),
                '("1","2")',
                'some_table',
            ),
            array(
                new DB_Type_Pgsql_Row(array(
                    'b' => new DB_Type_String(),
                    'a' => new DB_Type_String(),
                )),
                array('b'=>null, 'a'=>"zzz"),
                '(,"zzz")',
                null,
            ),
            array(
                new DB_Type_Pgsql_Row(array(
                    'a' => new DB_Type_String(),
                    'b' => new DB_Type_String(),
                    'c' => new DB_Type_Pgsql_Row(array(
                        'd' => new DB_Type_String(),
                        'e' => new DB_Type_String(),
                    ))
                )),
                array('a'=>"1", 'b'=>"2", 'c'=>array('d'=>'d"d', 'e'=>"5")),
                '("1","2","(""d""""d"",""5"")")',
                null,
            ),
            array(
                new DB_Type_Pgsql_Row(array(
                    'a' => new DB_Type_String(),
                    'b' => new DB_Type_String(),
                    'c' => new DB_Type_Pgsql_Array(new DB_Type_String())
                )),
                array('a'=>"1", 'b'=>"2", 'c'=>array("x", "y")),
                '("1","2","{""x"",""y""}")',
                null,
            ),
            array(
                new DB_Type_Pgsql_Row(array(
                    'a' => new DB_Type_String(),
                    'c' => new DB_Type_Pgsql_Row(array(
                        'd' => new DB_Type_String(),
                    ))
                )),
                array('a'=>"aaa", 'c'=>null),
                '("aaa",)',
                null,
            ),
            array(
                new DB_Type_Pgsql_Row(array(
                    'b' => new DB_Type_String(),
                    'a' => new DB_Type_String(),
                )),
                null,
                null,
                null,
            ),
            array(
                new DB_Type_Pgsql_Row(array()),
                "abcd",
                new DB_Type_Exception_Common(new DB_Type_Pgsql_Row(array()), "output", "row or null", "abcd"),
                null,
            ),
/*            array(
                new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())),
                array(),
                new DB_Type_Exception_Common(new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())), "output", "value for field 'a'", '<NO_SUCH_KEY>'),
            ),*/
            array(
                new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())),
                array("a" => "a\\b"),
                '("a\\\\b")',
                null,
            ),
        );
	}

    protected function _getPairsOutput()
    {
	    return array_merge(
            $this->_getCommonTests(),
            array(
	            'a' => array(
	                new DB_Type_Pgsql_Row(array(
	                    'b' => new DB_Type_String(),
	                    'a' => new DB_Type_Wrapper_EmptyToNull(new DB_Type_String()),
	                )),
	                array('b'=>null, 'a'=>""),
	                '(,)',
	                null
	            ),
				'b' => array(
					new DB_Type_Pgsql_Row( array(
						'b' => new DB_Type_String(),
						'a' => new DB_Type_Wrapper_EmptyToNull(new DB_Type_String()),
					)),
					(object) array('b'=> '1',
						  'a'=> 's'),
					'("1","s")',
					null
				),
				'c' => array(
					new DB_Type_Pgsql_Row(array(
						'b' => new DB_Type_Int(),
						'a' => new DB_Type_String(),
					)),
					array('b' => 'not_int', 'a' => ""),
					new DB_Type_Exception_Container(new DB_Type_Pgsql_Row(array()), 'output', 'b', 'DB_Type_Int::output() conversion error: given not_int, expected int32 value'),
					null
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
	                new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())),
	                new DB_Type_Exception_Common(new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())), "input", "start of a row '('", 'xxx'),
                    'xxx',
	            ),
                array(
                    new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())),
                    new DB_Type_Exception_Common(new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())), "input", "field 'a' value", '()', 1),
                    '()',
                ),
                array(
                    new DB_Type_Pgsql_Row(array()),
                    array(),
                    '()',
                ),
                array(
                    new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())),
                    new DB_Type_Exception_Common(new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())), "input", "end of the row: no more fields left", '("aa", "bb")', 7),
                    '("aa", "bb")',
                ),
                array(
                    new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())),
                    array("a" => "aa"),
                    '("aa")',
                ),
                array(
                    new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())),
                    array("a" => "aa"),
                    '(aa)',
                ),
                array(
                    new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())),
                    new DB_Type_Exception_Common(new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())), "input", "balanced quoted or unquoted string", '("aa)', 1),
                    '("aa)',
                ),
                array(
                    new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())),
                    new DB_Type_Exception_Common(new DB_Type_Pgsql_Row(array("a" => new DB_Type_String())), "input", "delimiter ',' or ')'", '(aa', 3),
                    '(aa',
                ),
    	        array(
                    new DB_Type_Pgsql_Row(array(
                        'b' => new DB_Type_String(),
                        'a' => new DB_Type_String(),
                    )),
    	            array('b'=>'ффф', 'a'=>"2"),
    	            '(ффф,"2")',
    	        ),
    	        array(
                    new DB_Type_Pgsql_Row(array(
                        'b' => new DB_Type_String(),
                        'a' => new DB_Type_String(),
                    )),
    	            array('b'=>"aaaaa aa", 'a'=>"2"),
    	            '("aaaaa aa","2")',
    	        ),
            )
        );
    }
}
