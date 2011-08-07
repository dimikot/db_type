<?php
class DB_Type_Test_TimestampTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_Timestamp(DB_Type_Timestamp::TRUNC_SECOND),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-03-02 12:34:22")),
                'TIMESTAMP',
            ),
            array(
                new DB_Type_Timestamp(DB_Type_Timestamp::TRUNC_MINUTE),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-03-02 12:34:00")),
                'TIMESTAMP',
            ),
            array(
                new DB_Type_Timestamp(DB_Type_Timestamp::TRUNC_HOUR),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-03-02 12:00:00")),
                'TIMESTAMP',
            ),
            array(
                new DB_Type_Timestamp(DB_Type_Timestamp::TRUNC_DAY),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-03-02 00:00:00")),
                'TIMESTAMP',
            ),
            array(
                new DB_Type_Timestamp(DB_Type_Timestamp::TRUNC_MONTH),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-03-01 00:00:00")),
                'TIMESTAMP',
            ),
            array(
                new DB_Type_Timestamp(DB_Type_Timestamp::TRUNC_YEAR),
                strtotime("2008-03-02 12:34:22"),
                date("r", strtotime("2008-01-01 00:00:00")),
                'TIMESTAMP',
            ),
            array(
                new DB_Type_Timestamp(),
                null,
                null,
                'TIMESTAMP',
            ),
        );
    }
}
