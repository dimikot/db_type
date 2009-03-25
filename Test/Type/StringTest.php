<?php
class DB_Pgsql_Type_Test_Type_StringTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_String(),
                "aaa",
                "aaa",
            ),
            array(
                new DB_Pgsql_Type_String(),
                false,
                "",
            ),
            array(
                new DB_Pgsql_Type_String(),
                null,
                null,
            ),
        );
    }
        
    protected function _getPairsInput()
    {
        return array(
            array(
                new DB_Pgsql_Type_String(),
                "aaa",
                "aaa",
            ),
            array(
                new DB_Pgsql_Type_String(),
                "",
                "",
            ),
            array(
                new DB_Pgsql_Type_String(),
                null,
                null,
            ),
        );
    }
}
