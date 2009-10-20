<?php
class DB_Pgsql_Type_Test_Type_EmptyNullTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_EmptyNull(
                    new DB_Pgsql_Type_String()
                ),
                "",
                null,
            ),
            array(
                new DB_Pgsql_Type_EmptyNull(
                    new DB_Pgsql_Type_Time()
                ),
                "",
                null,
            ),
            array(
                new DB_Pgsql_Type_EmptyNull(
                    new DB_Pgsql_Type_Boolean()
                ),
                false,
                "f",
            ),
            array(
                new DB_Pgsql_Type_EmptyNull(
                    new DB_Pgsql_Type_Boolean()
                ),
                true,
                "t",
            ),
        );
    }
}
