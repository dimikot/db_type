<?php
class DB_Pgsql_Type_Test_Type_LengthTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Length(new DB_Pgsql_Type_String(), 20),
                "1234567890",
                new DB_Pgsql_Type_Exception_Length(
                    new DB_Pgsql_Type_Length(new DB_Pgsql_Type_String(), 20),
                    "1234567890"
                ),
            ),
            array(
                new DB_Pgsql_Type_Length(new DB_Pgsql_Type_String(), 0, 2),
                "1234567890",
                new DB_Pgsql_Type_Exception_Length(
                    new DB_Pgsql_Type_Length(new DB_Pgsql_Type_String(), 0, 2),
                    "1234567890"
                ),
            ),
            array(
                new DB_Pgsql_Type_Length(new DB_Pgsql_Type_String(), 10),
                "1234567890",
                "1234567890",
            ),
        );
    }    
}
