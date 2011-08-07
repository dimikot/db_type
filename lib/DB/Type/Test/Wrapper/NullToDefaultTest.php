<?php
class DB_Type_Test_Wrapper_NullToDefaultTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_Wrapper_NullToDefault(
                	'abc',
                    new DB_Type_String()
                ),
                null,
                'abc', // result
                'VARCHAR',
            ),
            array(
                new DB_Type_Wrapper_NullToDefault(
                	'10:01:01',
                    new DB_Type_Time()
                ),
                null,
                '10:01:01',
                'TIME',
            ),
            array(
                new DB_Type_Wrapper_NullToDefault(
                	true,
                    new DB_Type_Pgsql_Boolean()
                ),
                null,
                "t",
                'BOOLEAN',
            ),
            array(
                new DB_Type_Wrapper_NullToDefault(
                	true,
                    new DB_Type_Pgsql_Boolean()
                ),
                false,
                "f",
                'BOOLEAN',
            ),
            array(
                new DB_Type_Wrapper_EmptyToNull(
                    new DB_Type_Pgsql_Boolean()
                ),
                true,
                "t",
                'BOOLEAN',
            ),
        );
    }
}
