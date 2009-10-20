<?php
class DB_Pgsql_Type_Test_Type_NumericTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Numeric(),
                "1234567890",
                "1234567890",
            ),
            array(
                new DB_Pgsql_Type_Numeric(10),
                "1234567890",
                "1234567890",
            ),
            array(
                new DB_Pgsql_Type_Numeric(10),
                "1234567890.54321",
                "1234567890.54321",
            ),
            array(
                new DB_Pgsql_Type_Numeric(10),
                "2.54321",
                "2.54321",
            ),
            array(
                new DB_Pgsql_Type_Numeric(1, 3),
                "2.243",
                "2.243",
            ),
            array(
                new DB_Pgsql_Type_Numeric(),
                "aaaa",
                new DB_Pgsql_Type_Exception_Numeric(
                    new DB_Pgsql_Type_Numeric(),
                    "aaaa"
                ),
            ),
            array(
                new DB_Pgsql_Type_Numeric(2),
                "123",
                new DB_Pgsql_Type_Exception_Numeric(
                    new DB_Pgsql_Type_Numeric(),
                    "123"
                ),
            ),
            array(
                new DB_Pgsql_Type_Numeric(2, 3),
                "2.3444",
                new DB_Pgsql_Type_Exception_Numeric(
                    new DB_Pgsql_Type_Numeric(),
                    "2.3444"
                ),
            ),
            array(
                new DB_Pgsql_Type_Numeric(),
                null,
                null,
            ),
        );
    }
}
