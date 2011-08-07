<?php
class DB_Type_Test_TimeTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_Time(),
                null,
                null,
                'TIME',
            ),
            array(
                new DB_Type_Time(DB_Type_Time::TRUNC_SECOND),
                "12:34:2",
                "12:34:02",
                'TIME',
            ),
            array(
                new DB_Type_Time(DB_Type_Time::TRUNC_MINUTE),
                "12:34:22",
                "12:34:00",
                'TIME',
            ),
            array(
                new DB_Type_Time(DB_Type_Time::TRUNC_HOUR),
                "12:34:22",
                "12:00:00",
                'TIME',
            ),
            array(
                new DB_Type_Time(),
                "12",
                "12:00:00",
                'TIME',
            ),
            array(
                new DB_Type_Time(),
                "6",
                "06:00:00",
                'TIME',
            ),
            array(
                new DB_Type_Time(),
                "12:15",
                "12:15:00",
                'TIME',
            ),
            array(
                new DB_Type_Time(),
                "02:15",
                "02:15:00",
                'TIME',
            ),
            array(
                new DB_Type_Time(),
                "2:15",
                "02:15:00",
                'TIME',
            ),
            array(
                new DB_Type_Time(),
                "9:25",
                "09:25:00",
                'TIME',
            ),
            array(
                new DB_Type_Time(),
                "12aaa",
                new DB_Type_Exception_Time(new DB_Type_Time(), "12aaa"),
                'TIME',
            ),
        );
    }

    protected function _getPairsInput()
    {
        return array(
            array(
                new DB_Type_Time(),
                null,
                null,
            ),
            array(
                new DB_Type_Time(DB_Type_Time::TRUNC_SECOND),
                "12:34:02",
                "12:34:02",
            ),
            array(
                new DB_Type_Time(DB_Type_Time::TRUNC_MINUTE),
                "12:34",
                "12:34:12",
            ),
            array(
                new DB_Type_Time(DB_Type_Time::TRUNC_HOUR),
                "12",
                "12:00:00",
            ),
        );
    }
}
