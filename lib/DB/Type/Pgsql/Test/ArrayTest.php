<?php
class DB_Type_Pgsql_Test_ArrayTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsInput()
    {
    	return array_merge(
            array(
		        array(
	                new DB_Type_Pgsql_Array(new DB_Type_String()),
		            array("1", "2", "3", "4"),
		            '{"1",  "2"  ,  "3",  "4",,,   }',
		            "VARCHAR[]",
		        ),
		        array(
	                new DB_Type_Pgsql_Array(new DB_Type_String()),
		            array("1", "2", "3", "44", null),
		            '{"1",  "2"  ,  "3",  "44",NULL,,   }',
		            "VARCHAR[]",
		        ),
		        array(
	                new DB_Type_Pgsql_Array(new DB_Type_Pgsql_Array(new DB_Type_String())),	        
		            array(array('1'), array(), array('zzz"3"'), array('4')),
		            '{{"1"},  {}  ,  {zzz"3"},  {"4"},,,   }',
		            "VARCHAR[][]",
		        ),
	            array(
	                new DB_Type_Pgsql_Array(new DB_Type_String()),            
	                null,
	                null,
	                "VARCHAR[]",
	            ),
	            array(
	                new DB_Type_Pgsql_Array(new DB_Type_String()),            
	                new DB_Type_Exception_Common(new DB_Type_Pgsql_Array(new DB_Type_String()), "input", "'{'", ' aaa', 1),
                    ' aaa',
	                "VARCHAR[]",
	            ),
                array(
                    new DB_Type_Pgsql_Array(new DB_Type_String()),            
                    new DB_Type_Exception_Common(new DB_Type_Pgsql_Array(new DB_Type_String()), "input", "scalar value", '{{aa}}', 1),
                    '{{aa}}',
                    "VARCHAR[]",
                ),
                array(
                    new DB_Type_Pgsql_Array(new DB_Type_String()),            
                    new DB_Type_Exception_Common(new DB_Type_Pgsql_Array(new DB_Type_String()), "input", "balanced quoted or unquoted string or sub-array", '{"a}', 1),
                    '{"a}',
                    "VARCHAR[]",
                ),
                array(
                    new DB_Type_Pgsql_Array(new DB_Type_String()),            
                    new DB_Type_Exception_Common(new DB_Type_Pgsql_Array(new DB_Type_String()), "input", "end of string", '{aaa} bbb', 5),
                    '{aaa} bbb',
                    "VARCHAR[]",
                ),
                array(
                    new DB_Type_Pgsql_Array(new DB_Type_Numeric()),
                    array("1", "2", null, "4"),
                    '{"1",  "2"  ,  NuLL,  "4",,,   }',
                    "BIGINT[]",
                ),
                array(
                    new DB_Type_Pgsql_Array(new DB_Type_Numeric(null, null, true)),
                    array("1", "2", null, "4"),
                    '{"1",  "2"  ,  NuLL,  "4",,,   }',
                    "BIGINT[]",
                ),
                array(
                    new DB_Type_Pgsql_Array(new DB_Type_Numeric()),
                    array(),
                    '{}',
                    "BIGINT[]",
                ),
                array(
                    new DB_Type_Pgsql_Array(new DB_Type_Numeric(null, null, true)),
                    new DB_Type_Exception_Common(new DB_Type_Pgsql_Array(new DB_Type_String()), "input", "balanced quoted or unquoted string or sub-array", '{', 1),
                    '{',
                    "BIGINT[]",
                ),
                array(
                    new DB_Type_Pgsql_Array(new DB_Type_Numeric(null, null, false)),
                    new DB_Type_Exception_Common(new DB_Type_Pgsql_Array(new DB_Type_String()), "input", "balanced quoted or unquoted string or sub-array", '{', 1),
                    '{',
                    "BIGINT[]",
                ),
            ),
            $this->_getPairsOutput()
        );
    }

    protected function _getPairsOutput()
    {
    	return array(
	        array(
                new DB_Type_Pgsql_Array(new DB_Type_String()),
	            array("1", "2", "3", "4"),
	            '{"1","2","3","4"}',
	            "VARCHAR[]",
	        ),
            array(
                new DB_Type_Pgsql_Array(new DB_Type_Pgsql_Array(new DB_Type_String())),
                array(array("1", "2", "3", "4")),
                '{{"1","2","3","4"}}',
                "VARCHAR[][]",
            ),
	        array(
                new DB_Type_Pgsql_Array(new DB_Type_String()),
	            array('aa"bb', 'vv\\nn"dd"\nxx'),
	            '{"aa\\"bb","vv\\\\nn\\"dd\\"\\\\nxx"}', // quoted, because 1d
	            "VARCHAR[]",
	        ),
            array(
                new DB_Type_Pgsql_Array(new DB_Type_String()),            
                array(),
                '{}',
                "VARCHAR[]",
            ),
            array(
                new DB_Type_Pgsql_Array(new DB_Type_String()),            
                'aaa',
                new DB_Type_Exception_Common(new DB_Type_Pgsql_Array(new DB_Type_String()), "output", "PHP-array or null", 'aaa'),
                "VARCHAR[]",
            ),
            array(
                new DB_Type_Pgsql_Array(
                    new DB_Type_Pgsql_Array(
                        new DB_Type_Time()
                    )
                ),
                array(array(null)),
                "{{NULL}}",
                "TIME[][]",
            ),
        );
    }
}
