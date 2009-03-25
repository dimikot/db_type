<?php
class DB_Pgsql_Type_Test_Type_IntTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Int(),
                "1234567890",
                "1234567890",
            ),
            array(
                new DB_Pgsql_Type_Int(),
                "aaaa",
                new DB_Pgsql_Type_Exception_Int(
                    new DB_Pgsql_Type_Int(),
                    "aaaa"
                ),
            ),
            array(
                new DB_Pgsql_Type_Int(),
                "777777777777777777777777777",
                new DB_Pgsql_Type_Exception_Int(
                    new DB_Pgsql_Type_Int(),
                    "777777777777777777777777777"
                ),
            ),
            array(
                new DB_Pgsql_Type_Int(),
                "-777777777777777777777777777",
                new DB_Pgsql_Type_Exception_Int(
                    new DB_Pgsql_Type_Int(),
                    "-777777777777777777777777777"
                ),
            ),            
            array(
                new DB_Pgsql_Type_Int(),
                null,
                null,
            ),
        );
    }    
}
