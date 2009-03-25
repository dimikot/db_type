<?php
class DB_Pgsql_Type_Test_Type_NestedTypesTest extends DB_Pgsql_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Trim(new DB_Pgsql_Type_Date()),
                "      01-02-03     ",
                "2001-02-03",
            ),
            array(
                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_Trim(new DB_Pgsql_Type_Date())),
                array("      01-02-03     "),
                '{"2001-02-03"}',
            ),
            array(
                new DB_Pgsql_Type_Trim(new DB_Pgsql_Type_Date()),
                null,
                null,
            ),
            array(
                new DB_Pgsql_Type_Array(
                    new DB_Pgsql_Type_Array(
                        new DB_Pgsql_Type_EmptyNull(
                            new DB_Pgsql_Type_Time()
                        )
                    )
                ),
                array(array("")),
                "{{NULL}}",
            ),             
        );
    }    
    
    protected function _getPairsInput()
    {
        return array(
            array(
                new DB_Pgsql_Type_Trim(new DB_Pgsql_Type_Date()),
                "2001-02-03",
                "2001-02-03",
            ),
            array(
                new DB_Pgsql_Type_Array(new DB_Pgsql_Type_Trim(new DB_Pgsql_Type_Date())),
                array("2001-02-03"),
                '{2001-02-03}',
            ),
            array( // WOW! Hstore of arrays of date!
                new DB_Pgsql_Type_Hstore(new DB_Pgsql_Type_Array(new DB_Pgsql_Type_Date())),
                array("aaa" => array("2001-02-03")),
                'aaa => "{2001-02-03}"',
            ),
            array(
                new DB_Pgsql_Type_Trim(new DB_Pgsql_Type_Date()),
                null,
                null,
            ),
        );
    }     
}
