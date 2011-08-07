<?php
class DB_Type_Test_StringTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_String(),
                "aaa",
                "aaa",
                'VARCHAR',
            ),
            array(
                new DB_Type_String(),
                false,
                "",
                'VARCHAR',
            ),
            array(
                new DB_Type_String(),
                null,
                null,
                'VARCHAR',
            ),
        );
    }
        
    protected function _getPairsInput()
    {
        return array(
            array(
                new DB_Type_String(),
                "aaa",
                "aaa",
            ),
            array(
                new DB_Type_String(),
                "",
                "",
            ),
            array(
                new DB_Type_String(),
                null,
                null,
            ),
        );
    }
}
