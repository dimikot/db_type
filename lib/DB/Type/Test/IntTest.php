<?php
class DB_Type_Test_IntTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_Int(),
                "1234567890",
                "1234567890",
                'INT',
            ),
            array(
                new DB_Type_Int(),
                "aaaa",
                new DB_Type_Exception_Int(
                    new DB_Type_Int(),
                    "aaaa"
                ),
                'INT',
            ),
            array(
                new DB_Type_Int(),
                "777777777777777777777777777",
                new DB_Type_Exception_Int(
                    new DB_Type_Int(),
                    "777777777777777777777777777"
                ),
                'INT',
            ),
            array(
                new DB_Type_Int(),
                "-777777777777777777777777777",
                new DB_Type_Exception_Int(
                    new DB_Type_Int(),
                    "-777777777777777777777777777"
                ),
                'INT',
            ),            
            array(
                new DB_Type_Int(),
                null,
                null,
                'INT',
            ),
        );
    }    
}
