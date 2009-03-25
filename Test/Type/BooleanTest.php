<?php
class DB_Pgsql_Type_Test_Type_BooleanTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Boolean(),
                true,
                "t",
            ),
            array(
                new DB_Pgsql_Type_Boolean(),
                false,
                "f",
            ),
            array(
                new DB_Pgsql_Type_Boolean(),
                0,
                "f",
            ),
            array(
                new DB_Pgsql_Type_Boolean(),
                100,
                "t",
            ),
            array(
                new DB_Pgsql_Type_Boolean(),
                '',
                "f",
            ),    
            array(
                new DB_Pgsql_Type_Boolean(),
                "false",
                "f",
            ),
        );
    }
        
    protected function _getPairsInput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Boolean(),
                true,
                "t",
            ),
            array(
                new DB_Pgsql_Type_Boolean(),
                false,
                "f",
            ),
            array(
                new DB_Pgsql_Type_Boolean(),
                true,
                "100",
            ),
            array(
                new DB_Pgsql_Type_Boolean(),
                false,
                "0",
            ),
            array(
                new DB_Pgsql_Type_Boolean(),
                null,
                null,
            ),
        );
    }
}
