<?php
class DB_Type_Test_Rwapper_TrimTest extends DB_Type_Test_Util_TypeTestCase
{
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_Wrapper_Trim(new DB_Type_String()),
                "      1234567890     ",
                "1234567890",
                'VARCHAR',
            ),
            array(
                new DB_Type_Wrapper_Trim(new DB_Type_String()),
                null,
                null,
                'VARCHAR',
            ),
        );
    }    
}
