<?php
class DB_Pgsql_Type_Test_Type_TimestampTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Timestamp(DB_Pgsql_Type_Timestamp::TRUNC_SECOND),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-03-02 12:34:22")),
            ),
            array(
                new DB_Pgsql_Type_Timestamp(DB_Pgsql_Type_Timestamp::TRUNC_MINUTE),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-03-02 12:34:00")),
            ),
            array(
                new DB_Pgsql_Type_Timestamp(DB_Pgsql_Type_Timestamp::TRUNC_HOUR),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-03-02 12:00:00")),
            ),
            array(
                new DB_Pgsql_Type_Timestamp(DB_Pgsql_Type_Timestamp::TRUNC_DAY),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-03-02 00:00:00")),
            ),
            array(
                new DB_Pgsql_Type_Timestamp(DB_Pgsql_Type_Timestamp::TRUNC_MONTH),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-03-01 00:00:00")),
            ),
            array(
                new DB_Pgsql_Type_Timestamp(DB_Pgsql_Type_Timestamp::TRUNC_YEAR),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-01-01 00:00:00")),
            ),
            array(
                new DB_Pgsql_Type_Timestamp(),
                null,
                null,
            ),
        );
    }
}
