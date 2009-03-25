<?php
class DB_Pgsql_Type_Test_Type_TrimTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Trim(new DB_Pgsql_Type_String()),
                "      1234567890     ",
                "1234567890",
            ),
            array(
                new DB_Pgsql_Type_Trim(new DB_Pgsql_Type_String()),
                null,
                null,
            ),
        );
    }    
}
