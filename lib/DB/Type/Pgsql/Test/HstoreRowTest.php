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
		return array_merge(
			$this->_getCommonTests(),
			array(
				'a' => array(
					new DB_Type_Pgsql_HstoreRow(array(
						'b' => new DB_Type_Int(),
						'a' => new DB_Type_String(),
					)),
					array('b' => 'not_int',
						  'a' => ""),
					new DB_Type_Exception_Container(new DB_Type_Pgsql_HstoreRow(array()), 'output', 'b', 'DB_Type_Int::output() conversion error: given not_int, expected int32 value'),
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
				// tests for itemsInput
				__LINE__ => array(
					new DB_Type_Pgsql_HstoreRow(array(
						'b' => new DB_Type_Int(),
						'a' => new DB_Type_Pgsql_Array(new DB_Type_Int()),
					)),
					array('b'=> "1", 'a'=> array('1', '2')),
					array('b'=> "1", 'a'=> '{1,2}')
				),
				/* Failed asserting in testInputOutputInput
    	        because output truncates `not_in_items` field.
    	        Usage example see in examples/itemsInput.php
				__LINE__ => array(
					new DB_Type_Pgsql_HstoreRow(array(
						'b' => new DB_Type_Int(),
						'a' => new DB_Type_Pgsql_Array(new DB_Type_Int()),
					)),
					array('b'=> "1", 'a'=> array('1', '2'), 'not_in_items'=>'5'),
					array('b'=> "1", 'a'=> '{1,2}', 'not_in_items'=> '5')
				),*/
				// tests for itemsInput
			)
		);
		return $this->_getCommonTests();
	}
}
