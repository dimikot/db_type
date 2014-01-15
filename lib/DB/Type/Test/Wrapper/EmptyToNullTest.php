<?php
class DB_Type_Test_Wrapper_EmptyToNullTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_Wrapper_EmptyToNull(
                    new DB_Type_Wrapper_NullToDefault('def', new DB_Type_String())
                ),
                null,
                'def',
                'VARCHAR',
            ),
            array(
                new DB_Type_Wrapper_EmptyToNull(
                    new DB_Type_String()
                ),
                "",
                null,
                'VARCHAR',
            ),
            array(
                new DB_Type_Wrapper_EmptyToNull(
                    new DB_Type_Time()
                ),
                "",
                null,
                'TIME',
            ),
            array(
                new DB_Type_Wrapper_EmptyToNull(
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
