<?php
class DB_Pgsql_Type_Test_Type_ArrayTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsInput()
    {
    	return array_merge(
            array(
		        array(
	                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()),
		            array("1", "2", "3", "4"),
		            '{"1",  "2"  ,  "3",  "4",,,   }',
		        ),
		        array(
	                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()),
		            array("1", "2", "3", "44", null),
		            '{"1",  "2"  ,  "3",  "44",NULL,,   }',
		        ),
		        array(
	                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String())),	        
		            array(array('1'), array(), array('zzz"3"'), array('4')),
		            '{{"1"},  {}  ,  {zzz"3"},  {"4"},,,   }',
		        ),
	            array(
	                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()),            
	                null,
	                null,
	            ),
	            array(
	                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()),            
	                new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()), "input", "'{'", ' aaa', 1),
                    ' aaa',
	            ),
                array(
                    new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()),            
                    new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()), "input", "scalar value", '{{aa}}', 1),
                    '{{aa}}',
                ),
                array(
                    new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()),            
                    new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()), "input", "balanced quoted or unquoted string or sub-array", '{"a}', 1),
                    '{"a}',
                ),
                array(
                    new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()),            
                    new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()), "input", "end of string", '{aaa} bbb', 5),
                    '{aaa} bbb',
                ),
	        ),
            $this->_getPairsOutput()
        );
    }

    protected function _getPairsOutput()
    {
    	return array(
	        array(
                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()),
	            array("1", "2", "3", "4"),
	            '{"1","2","3","4"}',
	        ),
            array(
                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String())),
                array(array("1", "2", "3", "4")),
                '{{"1","2","3","4"}}',
            ),
	        array(
                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()),
	            array('aa"bb', 'vv\\nn"dd"\nxx'),
	            '{"aa\\"bb","vv\\\\nn\\"dd\\"\\\\nxx"}', // quoted, because 1d
	        ),
            array(
                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()),            
                array(),
                '{}',
            ),
            array(
                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()),            
                'aaa',
                new DB_Pgsql_Type_Exception_Common(new DB_Pgsql_Type_Array(new DB_Pgsql_Type_String()), "output", "PHP-array or null", 'aaa'),
            ),
            array(
                new DB_Pgsql_Type_Array(
                    new DB_Pgsql_Type_Array(
                        new DB_Pgsql_Type_Time()
                    )
                ),
                array(array(null)),
                "{{NULL}}",
            ),
        );
    }
}
