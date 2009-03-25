<?php
class DB_Pgsql_Type_Test_Type_DateTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Date(),
                null,
                null,
            ),        
            array(
                new DB_Pgsql_Type_Date(DB_Pgsql_Type_Date::TRUNC_DAY),
                "12-10-2",
                "2012-10-02",
            ),
            array(
                new DB_Pgsql_Type_Date(DB_Pgsql_Type_Date::TRUNC_DAY),
                "75-10-2",
                "1975-10-02",
            ),
            array(
                new DB_Pgsql_Type_Date(DB_Pgsql_Type_Date::TRUNC_MONTH),
                "12-10-2",
                "2012-10-01",
            ),
            array(
                new DB_Pgsql_Type_Date(DB_Pgsql_Type_Date::TRUNC_YEAR),
                "12-10-2",
                "2012-01-01",
            ),
            array(
                new DB_Pgsql_Type_Date(),
                "12",
                "2012-01-01",
            ),            
            array(
                new DB_Pgsql_Type_Date(),
                "12-11",
                "2012-11-01",
            ),            
            array(
                new DB_Pgsql_Type_Date(),
                "12aaa",
                new DB_Pgsql_Type_Exception_Date(new DB_Pgsql_Type_Date(), "12aaa"),
            ),            
        );
    }
}
