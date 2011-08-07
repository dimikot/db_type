<?php
class DB_Type_Pgsql_Test_BooleanTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_Pgsql_Boolean(),
                true,
                "t",
                "BOOLEAN",
            ),
            array(
                new DB_Type_Pgsql_Boolean(),
                false,
                "f",
                "BOOLEAN",
            ),
            array(
                new DB_Type_Pgsql_Boolean(),
                0,
                "f",
                "BOOLEAN",
            ),
            array(
                new DB_Type_Pgsql_Boolean(),
                100,
                "t",
                "BOOLEAN",
            ),
            array(
                new DB_Type_Pgsql_Boolean(),
                '',
                "f",
                "BOOLEAN",
            ),    
            array(
                new DB_Type_Pgsql_Boolean(),
                "false",
                "f",
                "BOOLEAN",
            ),
        );
    }
        
    protected function _getPairsInput()
    {
        return array(
            array(
                new DB_Type_Pgsql_Boolean(),
                true,
                "t",
            ),
            array(
                new DB_Type_Pgsql_Boolean(),
                false,
                "f",
            ),
            array(
                new DB_Type_Pgsql_Boolean(),
                true,
                "100",
            ),
            array(
                new DB_Type_Pgsql_Boolean(),
                false,
                "0",
            ),
            array(
                new DB_Type_Pgsql_Boolean(),
                null,
                null,
            ),
        );
    }
}
